<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Laravelium\Sitemap\Sitemap;
use URL;

class GenerateSiteMap extends Command
{
    private $sitemap;
    public int $count;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:gen {count=200} {--no-categories}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate website sitemap for better SEO';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Sitemap $sitemap)
    {
        parent::__construct();

        $this->sitemap = $sitemap;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->count = (int) $this->argument('count');

        $this->warn('Generating Sitemap for ' . URL::to('/'));

        $this->generate();

        $this->sitemap->store('xml');

        if (file_exists(public_path('sitemap.xml'))) {
            $this->info('SiteMap Generated Sussfully');
        } else {
            $this->error('an error has occured');
        }
    }

    private function generate(): void
    {
        $this->add('/');
        $this->add('/login');
        $this->add('/register');

        $this->add('/projects', '0.9');
        $this->add('/categories', '0.8');

        Project::limit($this->count)
            ->get()
            ->each(
                fn(Project $pro) => $this->add(
                    "/projects/{$pro->slug}",
                    '0.9',
                    $pro->updated_at,
                    [
                        [
                            'url' => $pro->img_path,
                            'title' => $pro->title,
                        ],
                    ]
                )
            );

        if ($this->option('no-categories')) {
            return;
        }

        Category::all()->each(
            fn(Category $cat) => $this->add(
                "/categories/{$cat->slug}",
                '0.7',
                $cat->updated_at
            )
        );
    }

    private function add(
        string $url,
        string $pri = '1.0',
        ?string $updated = null,
        array $images = []
    ): void {
        $this->sitemap->add(
            URL::to($url),
            $updated ?? Carbon::now(),
            $pri,
            null,
            $images
        );
    }
}

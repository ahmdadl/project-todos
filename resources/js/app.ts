require('alpinejs');

import '@ryangjchandler/spruce';

require('./bootstrap');

// @ts-ignore
window.Spruce.store('toast', {
    arr: [],
    add(message: string, type: string = 'default') {
        this.arr.push({ show: true, message, type });
        setTimeout((_) => {
            this.remove(message);
        }, 4000);
        // console.log(message, type);
    },
    info(message: string) {
        this.add(message);
    },
    warn(message: string) {
        this.add(message, 'warn');
    },
    error(message: string) {
        this.add(message, 'danger');
    },
    success(message: string) {
        this.add(message, 'success');
    },
    remove(message: string) {
        const inx = this.arr.findIndex((x) => x.message === message);
        this.arr[inx].show = false;
        this.arr.splice(inx, 1);
    },
});

// @ts-ignore
window.Spruce.store('common', {
    dark:
        JSON.parse(localStorage.getItem('dark-theme') as string) ||
        (!!window.matchMedia &&
            window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleDark(): void {
        this.dark = !this.dark;
        localStorage.setItem('dark-theme', this.dark);
    },
    testMail(mail: string) {
        return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
            mail
        );
    },
});

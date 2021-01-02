require('./bootstrap');

import '@ryangjchandler/spruce';

require('alpinejs');

// @ts-ignore
window.Spruce.store('toast', {
    arr: [],
    add(message: string, type: string = 'default') {
        this.arr.push({ show: true, message, type });
        setTimeout((_) => {
            this.remove(message);
        }, 5000);
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

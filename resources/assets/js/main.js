import {bus} from "./app";

$(() => {
    $('.launch').on('click', function () {
        $('.sidebar').sidebar('setting', 'transition', 'overlay').sidebar('toggle');
    });

    $('#main-navigation').on('click', '.item:not(.header)', (event) => {
        bus.$emit('navigate', $(event.currentTarget).data('page'));
        $('.sidebar').sidebar('setting', 'transition', 'overlay').sidebar('toggle');
    });
});

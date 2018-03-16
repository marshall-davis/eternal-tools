import {vm} from "./app";

$(() => {
    $('.launch').on('click', function () {
        $('.sidebar').sidebar('setting', 'transition', 'overlay').sidebar('toggle');
    });
    console.log(vm);
    $('#main-navigation').on('click', '.item:not(.header)', (event) => {
        vm.page = $(event.currentTarget).data('page')
    });
});

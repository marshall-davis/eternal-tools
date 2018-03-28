import {bus} from "./app";

$(() => {
    let toggleSidbar = function () {
        $('.sidebar').sidebar('setting', 'transition', 'overlay').sidebar('toggle');
    };

    $('.launch').on('click', function () {
        toggleSidbar();
    });

    $('#main-navigation').on('click', '.item:not(.header, .action)', (event) => {
        bus.$emit('navigate', $(event.currentTarget).data('page'));
        toggleSidbar();
    });

    let submitTicket = function () {
        let $modal = $('.ui.report.modal');
        let ticketData = new FormData();

        $modal.find('input, textarea').each(function (index, elem) {
            let $elem = $(elem);

            console.log('Appending', $elem.attr('name'), $elem.val());
            ticketData.append($elem.attr('name'), $elem.val());
        });

        $.ajax({
            url: '/api/tickets',
            method: 'POST',
            processData: false,
            contentType: false,
            data: ticketData
        }).then(
            (response) => {
                console.log('Ticket processed.', response);
            },
            (error) => {
                console.log('Error', error);
            }
        );
    };

    $('#report-item').on('click', function () {
        $('.ui.report.modal').modal({
            onShow: function () {
                $('.email.help.icon').popup({
                    popup: $('.email.popup'),
                    on: 'hover',
                    variation: 'wide',
                    position: 'left center'
                });
            },
            onApprove: function () {
                submitTicket();
            }
        }).modal('show');
        toggleSidbar();
    });
});

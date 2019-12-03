$(document).ready(function() {
    $('.galeria').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            tClose: 'Fechar',
            tLoading: 'Carregando...',
            gallery: {
                enabled:true,
                tPrev: 'Anterior',
                tNext: 'Próxima',
                tCounter: '%curr% de %total%'
            },
            image: {
                tError: '<a href="%url%">A imagem</a> não pode ser carregada.'
            },
            ajax: {
                tError: '<a href="%url%">Arquivo</a> não encontrado.'
            }
        });
    });

    $('.zoom-video').magnificPopup({
        type:'iframe',
        tClose: 'Fechar',
        tLoading: 'Carregando...',
        gallery: {
            enabled:true,
            tPrev: 'Anterior',
            tNext: 'Próxima',
            tCounter: '%curr% de %total%'
        },
        image: {
            tError: '<a href="%url%">A imagem</a> não pode ser carregada.'
        },
        ajax: {
            tError: '<a href="%url%">Arquivo</a> não encontrado.'
        }
    });

    $('.zoom').magnificPopup({
        type:'image',
        tClose: 'Fechar',
        tLoading: 'Carregando...',
        gallery: {
            enabled:true,
            tPrev: 'Anterior',
            tNext: 'Próxima',
            tCounter: '%curr% de %total%'
        },
        image: {
            tError: '<a href="%url%">A imagem</a> não pode ser carregada.'
        },
        ajax: {
            tError: '<a href="%url%">Arquivo</a> não encontrado.'
        }
    });
});

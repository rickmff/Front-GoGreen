
var maskBehavior = function (val) {
  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {onKeyPress: function(val, e, field, options) {
        field.mask(maskBehavior.apply({}, arguments), options);
    }
};

$(document).ready(function(){
  $('.mask_date').mask('00/00/0000');
  $('.mask_time').mask('00:00:00');
  $('.mask_date_time').mask('00/00/0000 00:00:00');
  $('.mask_cep').mask('00000-000');
  $('.mask_cpf').mask('000.000.000-00', {reverse: true});
  $('.mask_money').mask('000.000.000.000.000,00', {reverse: true});
  $('.mask_phone').mask(maskBehavior, options);
});


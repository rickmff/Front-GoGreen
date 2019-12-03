function txtBoxFormat(objeto, sMask, evtKeyPress) 
   { 
      var i, nCount, sValue, fldLen, mskLen,bolMask, sCod, nTecla; 

      if(document.all) { // Internet Explorer 
       nTecla = evtKeyPress.keyCode; 
      } else if(document.layers) { // Nestcape 
       nTecla = evtKeyPress.which; 
      } else { 
       nTecla = evtKeyPress.which; 
       if (nTecla == 8) { 
      return true; 
    } 
   } 
    
   sValue = objeto.value; 

  // Limpa todos os caracteres de formatação que 
  // já estiverem no campo. 
  sValue = sValue.toString().replace( "-", "" ); 
  sValue = sValue.toString().replace( "-", "" ); 
  sValue = sValue.toString().replace( ".", "" ); 
  sValue = sValue.toString().replace( ".", "" ); 
  sValue = sValue.toString().replace( "/", "" ); 
  sValue = sValue.toString().replace( "/", "" ); 
  sValue = sValue.toString().replace( ":", "" ); 
  sValue = sValue.toString().replace( ":", "" ); 
  sValue = sValue.toString().replace( "(", "" ); 
  sValue = sValue.toString().replace( "(", "" ); 
  sValue = sValue.toString().replace( ")", "" ); 
  sValue = sValue.toString().replace( ")", "" ); 
  sValue = sValue.toString().replace( " ", "" ); 
  sValue = sValue.toString().replace( " ", "" ); 
  fldLen = sValue.length; 
  mskLen = sMask.length; 

  i = 0; 
  nCount = 0; 
  sCod = ""; 
  mskLen = fldLen; 

  while (i <= mskLen) { 
    bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/") || (sMask.charAt(i) == ":")) 
    bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " ")) 

    if (bolMask) { 
      sCod += sMask.charAt(i); 
      mskLen++; } 
    else { 
      sCod += sValue.charAt(nCount); 
      nCount++; 
    }      
    i++; 
  } 

  objeto.value = sCod; 

  if (nTecla != 8) { // backspace 
    if (sMask.charAt(i-1) == "9") { // apenas números... 
      return ((nTecla > 47) && (nTecla < 58)); } 
    else { // qualquer caracter... 
      return true; 
    } 
  } 
  else { 
    return true; 
  } 
  }
  
  /// ============ mascara telefone 9 digitos =============
  	function MascaraTelefone(o,f){
		v_obj=o
		v_fun=f
		setTimeout("execmascara()",1)
	}
	function execmascara(){
		v_obj.value=v_fun(v_obj.value)
	}
	function mask_tel(v){
		v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
		v=v.replace(/^(\d{2})(\d)/g,"($1) $2");//Coloca parênteses em volta dos dois primeiros dígitos
		v=v.replace(/(\d)(\d{4})$/,"$1-$2");//Coloca hífen entre o quarto e o quinto dígitos
		return v;
	}

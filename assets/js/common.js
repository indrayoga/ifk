/**
 * Common Java Script
 * Fungsi-fungsi umum javascript
 *
 * @access public
 * @author Agung Harry Purnama (agung.hp@awakami.com)
 * @since 9/19/2006 2:25PM
 */
function str_pad (input, pad_length, pad_string, pad_type) {
  // http://kevin.vanzonneveld.net
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // + namespaced by: Michael White (http://getsprink.com)
  // +      input by: Marco van Oort
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: str_pad('Kevin van Zonneveld', 30, '-=', 'STR_PAD_LEFT');
  // *     returns 1: '-=-=-=-=-=-Kevin van Zonneveld'
  // *     example 2: str_pad('Kevin van Zonneveld', 30, '-', 'STR_PAD_BOTH');
  // *     returns 2: '------Kevin van Zonneveld-----'
  var half = '',
    pad_to_go;

  var str_pad_repeater = function (s, len) {
    var collect = '',
      i;

    while (collect.length < len) {
      collect += s;
    }
    collect = collect.substr(0, len);

    return collect;
  };

  input += '';
  pad_string = pad_string !== undefined ? pad_string : ' ';

  if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
    pad_type = 'STR_PAD_RIGHT';
  }
  if ((pad_to_go = pad_length - input.length) > 0) {
    if (pad_type === 'STR_PAD_LEFT') {
      input = str_pad_repeater(pad_string, pad_to_go) + input;
    } else if (pad_type === 'STR_PAD_RIGHT') {
      input = input + str_pad_repeater(pad_string, pad_to_go);
    } else if (pad_type === 'STR_PAD_BOTH') {
      half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
      input = half + input + half;
      input = input.substr(0, pad_length);
    }
  }

  return input;
}
 
function xar_confirm(the_url, the_message){
    act = window.confirm(the_message);
    if (act == true){
        location.href = the_url;
    }
} 
function number_format(id,a, b, c, d) {
  a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
  e = a + '';
  f = e.split('.');
  if (!f[0]) {
  f[0] = '0';
  }
  if (!f[1]) {
  f[1] = '';
  }
  if (f[1].length < b) {
  g = f[1];
  for (i=f[1].length + 1; i <= b; i++) {
  g += '0';
  }
  f[1] = g;
  }
  if(d != '' && f[0].length > 3) {
  h = f[0];
  f[0] = '';
  for(j = 3; j < h.length; j+=3) {
  i = h.slice(h.length - j, h.length - j + 3);
  f[0] = d + i + f[0] + '';
  }
  j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
  f[0] = j + f[0];
  }
  c = (b <= 0) ? '' : c;
  document.getElementById(id).value  = f[0] + c + f[1];
} 

function addCommas(nStr){
  if(nStr=='0' || nStr=='NaN')return 0;
  nStr += '';
  zx = nStr.split('.');
  zx1 = zx[0];
  zx2 = zx.length > 1 ? '.' + zx[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(zx1)) {
    zx1 = zx1.replace(rgx, '$1' + '.' + '$2');
  }
  return zx1 + zx2;
}

function addCommas(nStr){
  if(nStr=='0' || nStr=='NaN')return 0;
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + '.' + '$2');
  }
  return x1 + x2;
}

	function validate(a) {

	        re=/^[a-zA-Z\_]*$/;

	        if(re.exec(document.getElementById(a).value)) {
				document.getElementById(a).value='';
	            document.getElementById(a).focus();
	            return;
	        }//end name if
	}
	function changevalue(a,b){
		
		document.getElementById(b).value  = stripNonNumeric(a);
	}
	
function stripNonNumeric( str ){
  str += '';
  var rgx = /^\d|\|-$/;
  var out = '';
  for( var i = 0; i < str.length; i++ ){
    if( rgx.test( str.charAt(i) ) ){
      if( !( ( str.charAt(i) == '.' && out.indexOf( '.' ) != -1 ) ||
             ( str.charAt(i) == '-' && out.length != 0 ) ) ){
        out += str.charAt(i);
      }
    }
  }
  return out;
}	


function showObject(the_id){
    var idObj = document.getElementById(the_id);
        
    if (idObj.style.display == "none"){
        idObj.style.display = "";
    }
}

function hideObject(the_id){
    var idObj = document.getElementById(the_id);
        
    if (idObj.style.display == ""){
        idObj.style.display = "none";
    }
}


function showHideObject(the_id){
    var idObj = document.getElementById(the_id);

    if (idObj.style.display == "none"){
        idObj.style.display = "";
    }else{
        idObj.style.display = "none";
    }    
}

function checkAllCheckbox(triggerObj, targetName){
    var nodeListObj = document.getElementsByName(targetName);

    if (triggerObj.checked){
        targetCheckedValue = true;
    }else{
        targetCheckedValue = false;
    }
   
    for (var i=0; i < nodeListObj.length; i++){
        if(nodeListObj[i].disabled){
            nodeListObj[i].checked = false;
        }
        else{            
            nodeListObj[i].checked = targetCheckedValue;
        }
    }
}

function checkAllCheckbox2(triggerObj, targetName, targetName2){
    var nodeListObj = document.getElementsByName(targetName);
    var nodeListObj2 = document.getElementsByName(targetName2);
    
    if (triggerObj.checked){
        targetCheckedValue = true;
    }else{
        targetCheckedValue = false;
    }
   
    for (var i=0; i < nodeListObj.length; i++){
        if(nodeListObj[i].disabled){
            nodeListObj[i].checked = false;
        }
        else{            
            nodeListObj[i].checked = targetCheckedValue;
        }
    }
    
    for (var i=0; i < nodeListObj2.length; i++){
        if(nodeListObj2[i].disabled){
            nodeListObj2[i].checked = false;
        }
        else{            
            nodeListObj2[i].checked = targetCheckedValue;
        }
    }
}

function formConfirmSubmit(theform, the_message){
    act = window.confirm(the_message);
    if (act == true){
        s = document.getElementById(theform);
        s.submit();
    }
}

function confirmDelete(delUrl) {
  if (confirm("Anda Yakin Ingin Menghapus Data Ini?")) {
	document.location = delUrl;
  }
}

function confirmSubmit(the_url, the_message){
    act = window.confirm(the_message);
    if (act == true){
        location.href = the_url;
    }
}

function goToURL(the_url){
    location.href = the_url;
}

function setCheckAllCheckboxStatus(checkAllID, watchedObjectName){
    var nodeListObj = document.getElementsByName(watchedObjectName);
    var checkAllObj = document.getElementById(checkAllID);
    
    var x = true;
    for (var i=0; i < nodeListObj.length; i++){
        if (!nodeListObj[i].checked && !nodeListObj[i].disabled){
            x = checkAllObj.checked = false;
            break;
        }
    }
    
    if (x) checkAllObj.checked = true;
}

function setCheckAllCheckboxStatus2(checkAllID, watchedObjectName, watchedObjectName2){
    var nodeListObj = document.getElementsByName(watchedObjectName);
    var nodeListObj2 = document.getElementsByName(watchedObjectName2);
    var checkAllObj = document.getElementById(checkAllID);
    
    var x = true;
    for (var i=0; i < nodeListObj.length; i++){
        if (!nodeListObj[i].checked && !nodeListObj[i].disabled){
            x = checkAllObj.checked = false;
            break;
        }
    }
    for (var i=0; i < nodeListObj2.length; i++){
        if (!nodeListObj2[i].checked && !nodeListObj2[i].disabled){
            x = checkAllObj.checked = false;
            break;
        }
    }    
    
    if (x) checkAllObj.checked = true;
}

function setButtonActivation(buttonID, watchedObjectName){
    var nodeListObj = document.getElementsByName(watchedObjectName);
    
    var status = false;    
    for (var i=0; i < nodeListObj.length; i++){
        if (nodeListObj[i].checked){
            status = true;
            break;
        }
    }
    if (status) 
        buttonActivate(buttonID);
    else
        buttonDeactivate(buttonID);
}

function setButtonActivation2(buttonID, watchedObjectName, watchedObjectName2){
    var nodeListObj = document.getElementsByName(watchedObjectName);
    var nodeListObj2 = document.getElementsByName(watchedObjectName2);
    
    var status = false;    
    for (var i=0; i < nodeListObj.length; i++){
        if (nodeListObj[i].checked){
            status = true;
            break;
        }
    }
    for (var i=0; i < nodeListObj2.length; i++){
        if (nodeListObj2[i].checked){
            status = true;
            break;
        }
    }
    if (status) 
        buttonActivate(buttonID);
    else
        buttonDeactivate(buttonID);
}

function setElementsActivation(objID, name1, name2){
    var obj = document.getElementById(objID);
    var nodeListObj1 = document.getElementsByName(name1);
    var nodeListObj2 = document.getElementsByName(name2);
    var status = true;
    
    if (obj.checked){    
        status = false;
    }
    
    for (var i=0; i < nodeListObj1.length; i++){
        nodeListObj1[i].disabled = status;
        nodeListObj2[i].disabled = status;
    }
}

function elementsActivation(objID, elemID1, elemID2){
    var obj = document.getElementById(objID);
    var elem1 = document.getElementById(elemID1);
    var elem2 = document.getElementById(elemID2);
    var status = true;
    
    if (obj.checked){    
        status = false;
    }
    
    elem1.disabled = status;
    elem2.disabled = status;
}

function setIdForId (idSeted, idSeter){
	var tempId = getElementById(idSeter);
	idSeted.value = tempId;	
}

function confirmSubmitDelete(triggerObj, urlDeleteID, watchedObjectName){
    var msg = "Apakah anda yakin akan menghapus data pilihan tersebut ?";
   // var urlDelete = document.getElementById(urlDeleteID).value;
    var urlDelete = urlDeleteID;
    
    var nodeListObj = document.getElementsByName(watchedObjectName);
    
    var urlArgs = "";
    for (var i=0; i < nodeListObj.length; i++){
        if (nodeListObj[i].checked){
            urlArgs += '&' + nodeListObj[i].name + '=' + nodeListObj[i].value;
        }
    }
            
    urlDelete += urlArgs;
    confirmSubmit(urlDelete, msg);
}

function confirmSubmitCetak(triggerObj, urlDeleteID, watchedObjectName){
    var msg = "Apakah anda yakin akan mencetak data tersebut ?";
   // var urlDelete = document.getElementById(urlDeleteID).value;
    
    var nodeListObj = document.getElementsByName(watchedObjectName);
    var urlDelete = urlDeleteID;
    
    var urlArgs = "";
    for (var i=0; i < nodeListObj.length; i++){
        if (nodeListObj[i].checked){
            urlArgs += '&' + nodeListObj[i].name + '=' + nodeListObj[i].value;
        }
    }
            
    urlDelete += urlArgs;
    confirmSubmit(urlDelete, msg);
}

// added  by Casmadi, S.Kom.
function confirmSubmitEdit(triggerObj, urlDeleteID, watchedObjectName){
    var msg = "Apakah anda ingin menambahkan NO Pemilih ?";
    var urlDelete = document.getElementById(urlDeleteID).value;
    
    var nodeListObj = document.getElementsByName(watchedObjectName);
    
    var urlArgs = "";
    for (var i=0; i < nodeListObj.length; i++){
        if (nodeListObj[i].checked){
            urlArgs += '&' + nodeListObj[i].name + '=' + nodeListObj[i].value;
        }
    }
            
    urlDelete += urlArgs;
    confirmSubmit(urlDelete, msg);
}
// Added by Joko Prastiyo, S.Kom.
function confirmSubmitInsert(triggerObj, urlInsertID, watchedObjectName){
    var msg = "Apakah anda yakin akan menambahkan semua data ini ?";
   // var urlInsert = document.getElementById(urlInsertID).value;
    var urlInsert = urlInsertID;
    
    var nodeListObj = document.getElementsByName(watchedObjectName);
    
    var urlArgs = "";
    for (var i=0; i < nodeListObj.length; i++){
        if (nodeListObj[i].checked){
            urlArgs += '&' + nodeListObj[i].name + '=' + nodeListObj[i].value;
        }
    }
            
    urlInsert += urlArgs;
    confirmSubmit(urlInsert, msg);
}

function confirmSubmitDelete2(triggerObj, urlDeleteID, watchedObjectName, watchedObjectName2){
    var msg = "Apakah anda yakin akan menghapus data pilihan tersebut ?";
    var urlDelete = document.getElementById(urlDeleteID).value;
    
    var nodeListObj = document.getElementsByName(watchedObjectName);
    var nodeListObj2 = document.getElementsByName(watchedObjectName2);
    
    var urlArgs = "";
    for (var i=0; i < nodeListObj.length; i++){
        if (nodeListObj[i].checked){
            urlArgs += '&' + nodeListObj[i].name + '=' + nodeListObj[i].value;
        }
    }
    for (var i=0; i < nodeListObj2.length; i++){
        if (nodeListObj2[i].checked){
            urlArgs += '&' + nodeListObj2[i].name + '=' + nodeListObj2[i].value;
        }
    }
    
    urlDelete += urlArgs;
    confirmSubmit(urlDelete, msg);
}

function buttonActivate(the_id){
    var idObj = document.getElementById(the_id);
    idObj.disabled = false;
}

function buttonDeactivate(the_id){
    var idObj = document.getElementById(the_id);
    idObj.disabled = true;
}

function popUpWindow(URLStr, winName, left, top, width, height)
{
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  
  var popUpWin = open(URLStr, winName, 'status=yes,toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
  popUpWin.focus();
}

function popUpFeeder(URLStr, winName, left, top, width, height, id_gi){
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  
  if(giObj = document.getElementById(id_gi)){
    if (giObj.value != ''){
        URLStr += "&search_gi" + "=" + giObj.value + "&search_mode=1";
      }
  }
   
  var popUpWin = open(URLStr, winName, 'status=yes,toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

function popUpJadual(URLStr, winName, left, top, width, height, id_gi, id_trafo){
  if(popUpWin)
  {
    if(!popUpWin.closed) popUpWin.close();
  }
  var tempstr ='';
  
  if(giObj = document.getElementById(id_gi)){
    if (giObj.value != ''){
        tempstr += "&search_gi" + "=" + giObj.value +"";
      }
  }
  
  if(trObj = document.getElementById(id_trafo)){
    if (trObj.value != ''){
        tempstr += "&search_trafo" + "=" + trObj.value +"";
      }
  }
  
  if(tempstr != '')
    URLStr += tempstr + "&search_mode=1";
  
  var popUpWin = open(URLStr, winName, 'status=yes,toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

function resetInput(idname, showname){
    var  x = document.getElementById(idname);
    var  y = document.getElementById(showname);
    
    x.value = '';
    y.value = '';
}            

function putValueToOpener(var_idname, var_idvalue, var_showname, var_showvalue){

    var idname = window.opener.document.getElementById(var_idname);
    var showname = window.opener.document.getElementById(var_showname);
    idname.value = var_idvalue;
    showname.value= var_showvalue;
    return;
}
function textToUpper(obj){
	obj.value = obj.value.toUpperCase();
}

function autoFocus(field, limit, next, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : 
        ((evt.which) ? evt.which : 0));
    if (charCode > 31 && field.value.length == limit) {
        field.form.elements[next].focus();
        field.form.elements[next].select();
    }
}



function validasi() {
   
   
   var c_d = document.getElementsByTagName('select');
   var c_m = document.getElementsByName('obj_bobot[]');
   
   var args = new Array();
   
   // <input type="text"..... /> = document.getElementByName)
   
   var c = 0;
   for (var x = 1; x <= c_d.length - 1; x++) {
   	   if (c_m[x-1].value == '' || c_m[x-1].value == 0) {
   	       alert('Bobot ada yang kosong !');
   	       c_m[x-1].value = '';   	       
   	       c_m[x-1].focus();   
   	       return false;
   	   } 
       args[c] = c_d[x].value;       
       c++;
   }
   
   for (var x = 0; x <= args.length - 1; x++) {        
       document.getElementById('td'+(x+1)).style.color = 'blue';
   }

   for (var x = 0; x <= args.length - 1; x++) {       
      for (var y = x + 1; y <= args.length - 1; y++) {      	        	  
      	  if (parseInt(args[x]) == parseInt(args[y])) {      	  	    
      	  	    
      	      alert('Terdapat mata pelajaran yang sama !');
      	      document.getElementById('td'+(x+1)).style.color = 'red';
      	      return false;
      	  }
      }       
   }   
   
   return true;
}

//author indrayoga
//fungsi fungsi di bawah ini memerlukan jquery download di www.jquery.com

function hideshow(el,act)
{
	if(act) $('#'+el).css('visibility','visible');
	else $('#'+el).css('visibility','hidden');
}

function hidedisplay(el,act)
{
	if(act) $('#'+el).css('display','block');
	else $('#'+el).css('display','none');
}

function objToString(o) {
	var s = '{\n';
	for (var p in o)
	s += ' "' + p + '": "' + o[p] + '"\n';
	return s + '}';
}

function elementToString(n, useRefs) {
	var attr = "", nest = "", a = n.attributes;
	for (var i=0; a && i < a.length; i++)
	attr += ' ' + a[i].nodeName + '="' + a[i].nodeValue + '"';
	if (n.hasChildNodes == false)
	return "<" + n.nodeName + "\/>";
	for (var i=0; i < n.childNodes.length; i++) {
		var c = n.childNodes.item(i);
		if (c.nodeType == 1) nest += elementToString(c);
		else if (c.nodeType == 2) attr += " " + c.nodeName + "=\"" + c.nodeValue + "\" ";
		else if (c.nodeType == 3) nest += c.nodeValue;
	}
	var s = "<" + n.nodeName + attr + ">" + nest + "<\/" + n.nodeName + ">";
	return useRefs ? s.replace(/</g,'&lt;').replace(/>/g,'&gt;') : s;
};
//tgl_lahir=dd-mm-yyyy
function hitungUmurTahun(tgl_lahir){
  tgl_lahir=tgl_lahir.split('-');
  var tgllahir=tgl_lahir[0];
  var bulanlahir=tgl_lahir[1];
  var tahunlahir=tgl_lahir[2];
}
//function load(){

//}
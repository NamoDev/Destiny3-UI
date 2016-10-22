/* Email validity checker */
function checkEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

/* Citizen ID Validity checker */
function checkCitizenID(id){
  if(id.length != 13){
    return false;
  }else{
    for(i=0, sum=0; i < 12; i++)
    sum += parseFloat(id.charAt(i))*(13-i);
    if((11-sum%11)%10!=parseFloat(id.charAt(12))){
      return false;
    }else{
      return true;
    }
  }
}

/* Alphanumeric validity checker */
function checkAlphanumeric(string){
    if(/^[A-Za-z][A-Za-z0-9]*$/.test(string)){
       return true;
    }else{
      return false;
    }
 }

/* Thai language checker */
function checkThai(string){
    var thai_characters="ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
    var isThai = true;
    for(i=0; i<string.length; i++){
        var charAt = string.charAt(i);
        if(thai_characters.indexOf(charAt) == -1){
            isThai = false;
        }
    }
    if(isThai){
        return true;
    }else{
        return false;
    }
}

/* Field blankness validator */
function isFieldBlank(fieldName){
    if($("#" + fieldName).val() != ""){
        $("#" + fieldName + "Group").removeClass("has-error");
        return 0;
    }else{
        $("#" + fieldName + "Group").addClass("has-error");
        return 1;
    }
}

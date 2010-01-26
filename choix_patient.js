// Original:  Anand Raman (anand_raman@poboxes.com)
// Web Site:  http://www.angelfire.com/ar/diduknow
// JavaScript pris sur le site: "http://www.java.scripts-fr.com"

function NomObjets(formname,selname,textname,str)
{
this.formname = formname;
this.selname = selname;
this.textname = textname;
this.select_str = str || '';
this.selectArr = new Array();
this.initialize = initialize;
this.bldInitial = bldInitial;
this.maj = maj;
}

function initialize()
{
if (this.select_str =='')
 {
 for(var i=0;i<document.forms[this.formname][this.selname].options.length;i++)
  {
  this.selectArr[i] = document.forms[this.formname][this.selname].options[i];
  this.select_str += 

document.forms[this.formname][this.selname].options[i].value+":"+document.forms[this.formname][this.selname].options[i].text+",";
   }
 }
else
 {
 var tempArr = this.select_str.split(',');
 for(var i=0;i<tempArr.length;i++)
  {
  var prop = tempArr[i].split(':');
  this.selectArr[i] = new Option(prop[1],prop[0]);
  }
 }
return;
}

function bldInitial()
{
this.initialize();
for(var i=0;i<this.selectArr.length;i++)
document.forms[this.formname][this.selname].options[i] = this.selectArr[i];
document.forms[this.formname][this.selname].options.length = this.selectArr.length;
return;
}

function maj()
{
var str = document.forms[this.formname][this.textname].value;
if(str == '') { this.bldInitial();return; }
this.initialize();
var j = 0;
pattern1 = new RegExp("^"+str,"i");
for(var i=0;i<this.selectArr.length;i++)
if(pattern1.test(this.selectArr[i].text)) 
document.forms[this.formname][this.selname].options[j++] = this.selectArr[i];
document.forms[this.formname][this.selname].options.length = j;
if(j==1)
 {
 document.forms[this.formname][this.selname].options[0].selected = true;
 }
}

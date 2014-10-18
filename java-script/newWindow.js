function newWindow(w,h,nav,loc,sts,menu,scroll,resize,name,url) {//v1.0
					 var windowProperties=''; if(nav==false) windowProperties+='toolbar=no,'; else
					 windowProperties+='toolbar=yes,'; if(loc==false) windowProperties+='location=no,'; 
					 else windowProperties+='location=yes,'; if(sts==false) windowProperties+='status=no,';
					 else windowProperties+='status=yes,'; if(menu==false) windowProperties+='menubar=no,';
					 else windowProperties+='menubar=yes,'; if(scroll==false) windowProperties+='scrollbars=no,';
					 else windowProperties+='scrollbars=yes,'; if(resize==false) windowProperties+='resizable=no,';
					 else windowProperties+='resizable=yes,'; if(w!="") windowProperties+='width='+w+',';
					 if(h!="") windowProperties+='height='+h; if(windowProperties!="") { 
					 if( windowProperties.charAt(windowProperties.length-1)==',') 
				     windowProperties=windowProperties.substring(0,windowProperties.length-1); } 
					 window.open(url,name,windowProperties);
}

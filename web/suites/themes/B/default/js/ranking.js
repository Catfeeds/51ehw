NINELEAF = function(id) {
	return document.getElementById(id);
}
function rankingdiv(divkey,id)
{
    for(var i=1;i<=5;i++)
       {
         NINELEAF(divkey + '_S' + i).style.display='';
         NINELEAF(divkey + '_B' + i).style.display='none';                        
        }
        NINELEAF(divkey + '_S' + id).style.display='none';              
        NINELEAF(divkey + '_B' + id).style.display='';
	    showimg("Img_"+divkey+"_"+id,"imgsrc_"+divkey+"_"+id);
}



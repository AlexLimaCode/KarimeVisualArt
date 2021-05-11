SelectSimple = function(){
    
    this.name="cmbSelectSimple";  
    this.id="cmbSelectSimple";  
    this.divContent="divSelectSimple";
    this.clase = "selectSimple";
    this.tagValue ="";
    this.tagText="";
    this.documentXml=null;
    
    this.multiple=false;
    this.rows=5;
    this.cols =20;
    
    this.sizeSelect = "100%";
    
    this.defaults=false;
    this.textDefaults ="Seleccione una opci\u00f3n";
    this.valueDefaults = 0;
    
    this.autoComplete = false;
    this.textAutoComplete = "textAutoComplete";
    this.idTextAutoComplete="textAutoComplete";
    
    this.onBlur = "";
    this.onChange = "";
    
    this.setOnBlur = function(onBlur){
        this.onBlur = onBlur; 
    }
    
    this.setOnChange = function(onChange){
        this.onChange = onChange; 
    }
    
    this.setMultiple = function(multiple){
        this.multiple=multiple;
    }
        
    this.setSizeSelect = function(sizeSelect){
        this.sizeSelect=sizeSelect;
    }
    
    this.setAutoComplete = function(autoComplete){
        this.autoComplete=autoComplete;  
    }
    
    this.setRows = function(rows){
        this.rows = rows; 
    }
    
    this.setCols = function(cols){
        this.cols=cols;  
    }
    
    this.setTextDefaults=function(textDefaults){
        this.textDefaults=textDefaults;
    }
    
    this.setValueDefaults = function(valueDefaults){
        this.valueDefaults=valueDefaults; 
    }
    
    this.setDefaults = function(defaults){
        this.defaults = defaults;
    }
    
    this.setTagValue = function(tagValue){
        this.tagValue=tagValue; 
    }
    
    this.setTagText = function(tagText){
        this.tagText = tagText;   
    }
  
    this.setName = function(name){
        this.name=name;   
    }  
    
    this.setId= function(id){
        this.id=id;   
    }
    
    this.setDivContent = function(divContent){
        this.divContent = divContent;  
    }
    
    this.setClase = function(clase){
        this.clase=clase;   
    }
    
    this.setDocumentXml= function(documentXml){
        this.documentXml=documentXml; 
    }
    
    this.create= function(){
        var cmbSelect = document.createElement("select");
        
        cmbSelect.className = this.clase;  
        cmbSelect.setAttribute("name", this.name);  
        cmbSelect.setAttribute("id", this.id);  
        try{
            cmbSelect.onchange = new Function(this.onChange);
        }catch(e){
            cmbSelect.setAttribute("onChange", this.onChange); 
        }
        
        if(this.multiple==true){
            cmbSelect.setAttribute("multiple", this.multiple);          
        }
        cmbSelect.style.width= this.sizeSelect;
        
        if(this.defaults==true){
            try{
                var option = document.createElement('option');
                option.text = this.textDefaults;
                option.value = this.valueDefaults;
                cmbSelect.add(option,null);
            }catch(e){
                cmbSelect.add(option);
            } 
        }
         
        for(var padre=0; padre < this.documentXml.childNodes.length; padre ++){
            if(typeof this.documentXml.childNodes[padre].tagName!="undefined"){
                for(var hijo=0; hijo < this.documentXml.childNodes[padre].childNodes.length; hijo++){
                    if( typeof this.documentXml.childNodes[padre].childNodes[hijo].tagName!="undefined"){
                        try{
                            var option = document.createElement('option');
                            option.text = this.documentXml.childNodes.item(padre).childNodes.item(hijo).getElementsByTagName(this.tagText).item(0).firstChild.nodeValue;
                            option.value = this.documentXml.childNodes.item(padre).childNodes.item(hijo).getElementsByTagName(this.tagValue).item(0).firstChild.nodeValue;
                            cmbSelect.add(option,null);
                        }catch(e){
                            cmbSelect.add(option);
                        }
                    
                    } 
                } 
            }
        }
        
        var divContent = document.getElementById(this.divContent);
        divContent.innerHTML="";
        divContent.appendChild(cmbSelect);
        
        if(this.autoComplete==true){
            var textAutoComplete = document.createElement("input"); 
            textAutoComplete.setAttribute("type", "text");
            textAutoComplete.setAttribute("name", this.textAutoComplete);
            textAutoComplete.setAttribute("id", this.idTextAutoComplete);
            
            textAutoComplete.className=this.clase;
            try{
                textAutoComplete.onblur=new Function(this.onBlur);
            }catch(e){
                textAutoComplete.setAttribute("onBlur", this.onBlur);
            }
            
            textAutoComplete.style.width= this.sizeSelect;
            try{
                textAutoComplete.onkeyup = new Function("if(pressKey(event)==1){"+
                    "buscarDescripcion(this.value,'" + this.id + "')" +
                    "}");  
            }catch(e){
                textAutoComplete.setAttribute("onKeyup", "if(pressKey(event)==1){"+
                    "buscarDescripcion(this.value,'" + this.id + "')" +
                    "}");
            }
            
            divContent.appendChild(textAutoComplete);
        }
        
        
    }
  
}

buscarDescripcion = function(text,cmbselect){
    var cmbselect = document.getElementById(cmbselect);
    for( var index=0; index < cmbselect.length; index++){
        cmbselect.options[index].selected=false;  
    }
    eval("var patron = /(^" + text.toUpperCase().trim() + ")|(" + text.toUpperCase().trim() + "*)/g");
    for( var index=0; index < cmbselect.length; index++){
        var pos = cmbselect.options[index].text.toUpperCase().indexOf(text.toUpperCase().trim());  
        if(pos > -1){
            cmbselect.options[index].selected=true;  
            break;
        }
    }
}
    
pressKey = function(evento){
    var teclaPresionada=(document.all) ? evento.keyCode : evento.which;
    switch(teclaPresionada){
        case 32:
            return 1;
            break;
        default:
            return 0;
    } 
}

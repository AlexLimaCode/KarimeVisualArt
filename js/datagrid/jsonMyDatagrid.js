JsonMyDatagrid = function() {

    this.imagenPath = "../../img/";
    this.headers = new Array();
    this.documentJson = null;
    this.documentDiv = "";
    this.TagShow = new Array();
    this.TagHidden = new Array();
    this.TagImg = "";
    this.showImg = "";

    this.onclick = "";
    this.TagParam = "";

    this.title = "";

    this.mouseOver = "#FF00FF";
    this.mouseOut = "#FFFFFF";
    this.clase = "DataGrid";

    this.tamCols = new Array();
    this.styleCols = new Array();

    this.paginacion = true;
    this.numPags = 0;
    this.numRegs = 0;
    this.numFilas = 1;
    this.totalPaginas = 0;
    this.showPagina = "";
    this.pag = 0;

    this.sizeTable = "100%";
    this.border = 0;
    this.par = 0;

    this.headersP = new Array();
    this.colspanP = new Array();
    this.styleColsP = new Array();

    this.setHeadersP = function() {
        for (var index = 0; index < arguments.length; index++) {
            this.headersP[index] = arguments[index].toUpperCase();
        }
    }

    this.setColspanP = function() {
        for (var index = 0; index < arguments.length; index++) {
            this.colspanP[index] = arguments[index].toUpperCase();
        }
    }

    this.setStyleColsP = function() {
        for (var index = 0; index < arguments.length; index++) {
            this.styleColsP[index] = arguments[index].toUpperCase();
        }
    }

    this.setTagImg = function(TagImg) {
        this.TagImg = TagImg;
    }

    this.setShowImg = function(showImg) {
        this.showImg = showImg;
    }

    this.setImagenPath = function(path) {
        this.imagenPath = path;
    }

    this.setMouseOver = function(color) {
        this.mouseOver = color;
    }

    this.setMouseOut = function(color) {
        this.mouseOut = color;
    }

    this.setClase = function(c) {
        this.clase = c;
    }

    this.setBorder = function(b) {
        this.border = b;
    }

    this.setSizeTable = function(size) {
        this.sizeTable = size;
    }

    this.setHeaders = function() {
        for (var index = 0; index < arguments.length; index++) {
            this.headers[index] = arguments[index].toUpperCase();
        }
    }

    this.setTamCols = function() {
        for (var index = 0; index < arguments.length; index++) {
            this.tamCols[index] = arguments[index];
        }
    }

    this.setStyleCols = function() {
        for (var index = 0; index < arguments.length; index++) {
            this.styleCols[index] = arguments[index];
        }
    }

    this.setTagShow = function() {
        for (var index = 0; index < arguments.length; index++) {
            this.TagShow[index] = arguments[index];
        }
    }

    this.setTagHidden = function() {
        for (var index = 0; index < arguments.length; index++) {
            this.TagHidden[index] = arguments[index];
        }
    }

    this.setDocumentJson = function(json) {
        this.documentJson = eval("(" + json + ")");
    }

    this.setDocumentDiv = function(div) {
        this.documentDiv = div;
    }

    this.setOnclick = function(functions, TagParam) {
        this.strClick = functions;
        this.TagParam = TagParam;
    }

    this.setShowPagina = function(functions) {
        this.showPagina = functions;
    }

    this.setTitle = function(title) {
        this.title = title.toUpperCase();
    }

    this.setPaginacion = function(paginacion) {
        this.paginacion = paginacion;
    }


    this.setNumFilas = function(numFilas) {
        this.numFilas = numFilas;
    }

    this.loadJson = function() {

        var datagrid = document.createElement("table");
        var thead = document.createElement("thead");
        var tr = document.createElement("tr");
        var td = document.createElement("td");

        datagrid.setAttribute("border", this.border);//
        datagrid.setAttribute("cellpadding", 0);
        datagrid.setAttribute("cellspacing", 0);
        datagrid.setAttribute("width", this.sizeTable);
        datagrid.className = this.clase;

        td.appendChild(document.createTextNode(this.title));

        td.setAttribute("align", "center");
        td.colSpan = this.headers.length;

        tr.appendChild(td);
        tr.className = "titulo";
        thead.appendChild(tr);

        if (this.paginacion) {

            this.pag = this.documentJson.pagina.total;
            this.numRegs = this.documentJson.total.total;

            this.totalPaginas = Math.ceil(this.numRegs / this.numFilas);

            var tr = document.createElement("tr");
            var td = document.createElement("td");
            td.appendChild(document.createTextNode("Total: " + this.numRegs));
            td.setAttribute("align", "center");
            tr.appendChild(td);

            var td = document.createElement("td");
            td.appendChild(document.createTextNode("Paginas: "));
            td.setAttribute("align", "right");
            tr.appendChild(td);
            tr.setAttribute("class", "paginas");
            var td = document.createElement("td");
            var cmbSelect = document.createElement("select");
            cmbSelect.setAttribute("class", "select");
            for (var index = 1; index <= this.totalPaginas; index++) {
                try {
                    var option = document.createElement('option');
                    option.text = index;
                    option.value = index;
                    if (this.pag == index) {
                        option.selected = true;
                    }
                    cmbSelect.add(option, null);
                } catch (e) {
                    cmbSelect.add(option);
                }
            }
            try {
                cmbSelect.onchange = new Function(this.showPagina + "(this.value)");
            } catch (e) {
                cmbSelect.setAttribute("onChange", this.showPagina + "(this.value)");
            }
            td.appendChild(cmbSelect);
            td.colSpan = (this.headers.length - 2);
            tr.appendChild(td);
            thead.appendChild(tr);
        }

        var tr = document.createElement("tr");
        tr.className = "header";
        for (var index = 0; index < this.headersP.length; index++) {
            var td = document.createElement("td");
            var div = "<div id='divHeader' width='100%' height='100%' class='" + this.styleColsP[index] + "'>";
            div += this.headersP[index];
            div += "</div>";
            try {
                td.colSpan = this.colspanP[index];
            } catch (e) {
                td.setAttribute("colspan", this.colspanP[index]);
            }
            td.innerHTML = div;
            tr.appendChild(td);
        }
        thead.appendChild(tr);
        datagrid.appendChild(thead);

        var tr = document.createElement("tr");
        tr.className = "header";
        for (var index = 0; index < this.headers.length; index++) {
            var td = document.createElement("td");
            var div = "<div id='divHeader' width='100%' height='100%' class='" + this.styleCols[index] + "'>";
            div += this.headers[index];
            div += "</div>";
            td.setAttribute("width", this.tamCols[index]);
            td.innerHTML = div;
            tr.appendChild(td);
        }
        thead.appendChild(tr);
        datagrid.appendChild(thead);

        var tbody = document.createElement("tBody");
        var count = (this.pag - 1) * this.numFilas;

        for (var index = 0; index < this.documentJson.resultados.length; index++) {
            var tr = document.createElement("tr");

            if ((index % 2) == 0) {
                tr.setAttribute("class", "renglonPares");
                tr.className = "renglonPares";
            } else {
                tr.setAttribute("class", "renglonImpares");
                tr.className = "renglonImpares";
            }

            try {
                tr.onmouseover = "this.style.cursor='pointer'";
                tr.onmouseout = this.style.cursor = 'default';
            } catch (e) {
                tr.setAttribute("onMouseOver", "this.style.background='" + this.mouseOver + "'; this.style.cursor='pointer'");
                tr.setAttribute("onMouseOut", "this.style.background='" + this.mouseOut + "'; this.style.cursor='default'");
            }

            var td = document.createElement("td");
            count += 1;
            td.appendChild(document.createTextNode(count));

            tr.appendChild(td);
            tbody.appendChild(tr);

            for (var tags = 0; tags < this.TagShow.length; tags++) {
                var td = document.createElement("td");
                eval("td.appendChild(document.createTextNode(this.documentJson.resultados[index]." + this.TagShow[tags] + "));\n");

                if (this.strClick.trim() != "") {
                    try {
                        eval("td.onclick = new Function(this.strClick + \"('\" + this.documentJson.resultados[index]." + this.TagParam + "  + \"')\")");
                    } catch (e) {
                        eval("td.setAttribute(\"onClick\", this.strClick + \"('\" + this.documentJson.resultados[index]." + this.TagParam + " + \"'))");
                    }
                }

                tr.appendChild(td);
            }
            tbody.appendChild(tr);
        }

        datagrid.appendChild(tbody);
        var documentDiv = document.getElementById(this.documentDiv);
        documentDiv.innerHTML = "";
        documentDiv.appendChild(datagrid);
    }
}
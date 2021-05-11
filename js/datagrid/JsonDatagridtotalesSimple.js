generaGrid = function(json, headers, TagShow, TagWidth, hidden, evento, div, paginacion, pagina, cantxPag) {
    var Json = eval("(" + json + ")");
    var totPaginas = Json.paginasTotales.total;
    var totregistros = Json.registrosTotales.total;
    var long = Json.resultados.length;
    var divRes = document.getElementById(div);
    var html = "<table border='0' width='100%' class='Arial12 lista-table'>";
    //paginación
    html += "<thead>";
    if (paginacion) {
        html += "<tr class='thead'>";
        html += "<td align='left' colspan ='2'> <b>Página: </b> ";

        html += "<select style='width:15%' class='frmCaja' id='cmbpagina' onchange='inicia();'>";
        for (var index = 1; index <= totPaginas; index++) {
            html += "<option value='" + index + "'";
            if (pagina == index) {
                html += " selected ";
            }
            html += ">" + index + "</option>";
        }
        html += "</select></td>";

        html += "<td align='left' colspan='2'> <b>Total Registros: <b>" + totregistros + "</b> </td>";

        html += "</tr>";
    }
    html += "<tr class='thead'>";
    html += "<td width='5%' align='center' > <b>No.</b> </td>";
    for (var indHead = 0; indHead < headers.length; indHead++) {
        html += "<td width='" + TagWidth[indHead] + "' align='center'><b>" + headers[indHead] + " </b></td>";
    }
    html += "</tr>";
    html += "</thead>";
    if (long !== 0) {
        var contador = 1;
        if (pagina > 1)
        {
            contador = (pagina - 1) * cantxPag;
            contador++;
        } else {
            contador = 1;
        }
        for (var JsonIndex = 0; JsonIndex < long; JsonIndex++) {

            hddvalue = "Json.resultados[JsonIndex]." + hidden;
            onClick = "onclick='" + evento + "(" + eval(hddvalue) + ") '";
            if (JsonIndex % 2 === 0) {
                html += "<tr style='background-color: #E2EBF4' id='RowResultado" + JsonIndex + "' onmouseover='mOver(this.id)' onmouseout='mOut(this.id,1)' " + onClick + ">";
            } else {
                html += "<tr style='background-color: #CFDDEA' id='RowResultado" + JsonIndex + "' onmouseover='mOver(this.id)' onmouseout='mOut(this.id,2)' " + onClick + ">";
            }

//            var cont = JsonIndex + 1;

            html += "<td>" + contador + "</td>";
            for (var indBody = 0; indBody < TagShow.length; indBody++) {
                var muestra = TagShow[indBody];
                var objeto = "Json.resultados[JsonIndex]." + muestra;
                html += "<td>" + eval(objeto) + "</td>";
            }
            html += "</tr>";
            contador++;
        }
        html += "<tr><td></td><td><strong>Total</strong></td><td><strong>" + Json.totales.totalPendientes + "</strong></td><td><strong>" + Json.totales.totalContestados + "</strong></td></tr>";
        html += "<tr><td></td><td></td><td><strong>Total General</strong></td><td><strong>" + Json.totales.totalGeneral + "</strong></td></tr>";
    } else {
        html += "<td colspan='" + headers.length + 1 + "' align='center'>Sin Resultados</td>";
    }
    html += "</table>";
    divRes.style.display = "block";
    divRes.innerHTML = html;
};

mOver = function(id) {
    var trUsr = document.getElementById(id);
    trUsr.style.background = "#FFFFFF";
};
mOut = function(id, color) {
    var trUsr = document.getElementById(id);
    if (color == 1) {
        trUsr.style.background = "#E2EBF4";
    } else {
        trUsr.style.background = "#CFDDEA";
    }
};
divLoad = function(div, status) {
    var divOrigen = document.getElementById(div);
    if (status === "1") {
        divOrigen.innerHTML = "<img src='img/cargando.gif'>";
    } else if (status === "2") {
        divOrigen.innerHTML = "";
    }
};
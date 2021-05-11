isFechaMysql = function(object){
    var Fecha= new String(object)
    var RealFecha= new Date()

    var Dia= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))
    var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))
    var Ano= new String(Fecha.substring(0,Fecha.indexOf("-")))
    
    Dia = Dia.split(" ");
    Dia = Dia[0];

    if(isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900) return false
    if(isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12) return false
    if(isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31) return false

    if(Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2)
        if (Mes==2 && Dia > 29 || Dia>30) return false

    return true
}


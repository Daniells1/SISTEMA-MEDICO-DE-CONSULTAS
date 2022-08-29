const format = (field, event) => {
    if(event.keyCode == 8) return; //saia da função
    if(event.keyCode == 9) return; //saia da função

    let key = event.key //Valor atual que foi digitado

    let mask = field.getAttribute("data-mask")//pegar a mascara definida no campo
    let value = field.value //valor total da string que esta no campo
    let tamString = value.length // tamanho da string que que esta nos campos

    let keyMask = mask.charAt(tamString)// o valor referente ao tamanho da string em relação a mascara
    if(keyMask == "" || keyMask == null){
        event.preventDefault()
        return;
    }

    switch(keyMask){
        case '9':
        var regex = new RegExp("\\d")
        if(!regex.test(key)){
            event.preventDefault()
            return;
        }
        break;
        case 'A':
            var regex = new RegExp("[a-z]","i")
            if(!regex.test(key)){
                event.preventDefault()
                return;
            }
            break;
        default:
            field.value = field.value + keyMask;
            format(field,event)
    }
}
document.querySelectorAll("[data-mask]").forEach((field) =>{
    field.addEventListener("keydown",(event)=>{
        format(field,event)
    })
    

})
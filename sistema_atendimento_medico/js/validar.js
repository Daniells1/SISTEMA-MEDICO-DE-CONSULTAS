document.querySelector(".data-form").addEventListener('blur',(event)=>{
    let valor = event.target.value
    let dateValid = dayjs(valor, 'DD/MM/YYYY', true).isValid() 
    if(!dateValid){
        event.target.value = ""
        alert("Preencha uma data válida")
    }
})
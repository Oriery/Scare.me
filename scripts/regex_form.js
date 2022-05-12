function doRegExTask() {
    var el_message = document.getElementById("input_message");
    let regex = /(([а-яА-Я]|\w){6})([а-яА-Я]|\w)+/gm;

    el_message.value = el_message.value.replace(regex, '$1*');
}
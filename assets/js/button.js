/*
Подключение: в шаблоне, в файле header.php, перед закрывающим тегом head(</head>) добавить строку:
<script type="text/javascript" src="/wp-content/plugins/bulletin_board/assets/js/button.js"></script>
*/


function getButton(buttonID)
{
    if (document.getElementById) {return document.getElementById(buttonID);}
    else if (document.all) {return document.all[buttonID];}
    else if (document.layers) {return document.layers[buttonID];}
}

function CSSLoad(file){
    var link = document.createElement("link");
    link.setAttribute("rel", "stylesheet");
    link.setAttribute("type", "text/css");
    link.setAttribute("href", file);
    document.getElementsByTagName("head")[0].appendChild(link)
}

function addButton() {
    var button = document.createElement("div");
    button.setAttribute("id", "bulletin_board_button");
    button.innerHTML = "<a href='/bulletin_board/'>Доска объявлений</a>";
    if (!getButton('bulletin_board_button')) {
        CSSLoad('/wp-content/plugins/bulletin_board/assets/css/button.css');
        document.getElementsByTagName("body")[0].appendChild(button);
    }
}

document.addEventListener('DOMContentLoaded', function(){
    addButton();
});
<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
CJSCore::Init(array('ajax'));
$arNewEl = array(
    "NAME" => "",
    "ACTIVE_FROM" => "",
    "DETAIL_TEXT" => "",
    "IDENTIFICATOR" => ""
);

if ($USER->IsAuthorized() != false) {
    $USERID = $USER->GetID();
} else {
    $USERID = "0";
}


function display_comments(array $comments, $level = 0, $ID)
{
    echo '<ul id="list_comments">';
    foreach ($comments as $com) {
        $parentId = $com["PROPERTIES"]["id_parent_coomment"]["VALUE"];
        if (empty($com["PROPERTIES"]["id_parent_coomment"]["VALUE"])) {
            $parentId = 0;
        }
        $name = $com["NAME"];
        if ($ID == $com["PROPERTIES"]['ID_USER']["VALUE"]) {
            $name = "Ваш комментарий";
        }

        echo '<li><div class="block_com" id="' . $com["ID"] . "-" . $parentId . '">
                    <div class="wrap-bl">
                        <div class="name">' . $name . '</div>
                    <div class="date">' . $com["DATE_ACTIVE_FROM"] . '</div>
                    </div>
                    <div class="comments">' . $com["DETAIL_TEXT"] . '</div>
                    <a href="" class="ask scroll-to">Ответить</a>
                </div>';
        if (!empty($com['CHILD'])) {
            display_comments($com['CHILD'], $level + 1, $ID);
        }
        echo '</li>';
    }
    echo '</ul>';
}

?>


<div class="wrap-message">
    <h3>Комментарии</h3>
    <form class="form">

        <? if ($USER->IsAuthorized() == false): ?>
            <div class="mf-tx">
                <label for="name">Введите ваше имя и фамилию</label>
                <input type="text" id="name" class="user_name" name="user_name" value="" required>
                <input type="hidden" id="auth_is" value="false">

            </div>
        <? else: ?>
            <input type="hidden" name="user_name" id="name" class="user_name" value="<?= $USER->GetFullName() ?>">
            <input type="hidden" id="auth_is" value="true">
        <? endif ?>
        <div class="mf-tx">
            <label for="message">Текст комментария</label>
            <textarea name="MESSAGE" class="message" rows="5" cols="40" id="message" required></textarea>
        </div>
        <input type="hidden" class='hide_id' id="hide_id" name="id" value="<?= $arParams["OBJECT_COMMENT"] . '-' ?>">
        <div class="cl-btn-2" type="hidden">
            <div>
                <div class="leftright"></div>
                <div class="rightleft"></div>
            </div>
            <div class="name-ask"></div>
        </div>
        <button class="button" name="button" id="my-button">Отправить</button>

    </form>
    <div class="wrap_comments">
        <? display_comments($arResult, 0, $USERID); ?>

    </div>
</div>
<?

?>
<script>
    const anchors = document.querySelectorAll('a.scroll-to')
    let flag = false;
    let btn_del = document.querySelector('.cl-btn-2');
    let id = BX('hide_id');
    let arr = id.value.split('-');
    for (let anchor of anchors) {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const blockID = anchor.getAttribute('href')
            document.querySelector(".form").scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            })
            let block = anchor.parentNode;
            console.log(block);
            let hide = document.querySelector('.hide_id');
            hide.value = hide.value + block.id;
            if (flag == true) {
                hide.value = arr[0] + "-" + block.id;
            }
            flag = true;
            document.querySelector('#message').value = block.querySelector('.name').innerHTML + ",";
            console.log(document.querySelector('#message').value);
            btn_del.style.display = 'flex';
            btn_del.querySelector('.name-ask').innerHTML = block.querySelector('.name').innerHTML;

        })
    }
    btn_del.addEventListener('click', function (e) {
        if (flag == true) {
            flag = false;
            btn_del.style.display = 'none';
            document.querySelector('#message').value = "";
            document.querySelector('.hide_id').value = arr[0] + "-";
        }

    })

    if (flag === false) {
        arr[1] = 0;
    }

    BX.bind(BX('my-button'), 'click', e => {
        let now = new Date();
        let month = now.getMonth();
        if (month < 10) month = 0 + "" + month;
        let date = now.getDate() + "." + month + "." + now.getFullYear() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
        let name = BX('name').value;
        let message = BX('message').value;
        if (flag == true) {
            arr = id.value.split('-');
        }
        e.preventDefault();
        if (name != "" && message != "") {

            BX.ajax({
                method: 'POST',
                data: {
                    name_user: name,
                    message_txt: message,
                    parent_is: flag,
                    idendificator: arr[0],
                    id_parent_coomment: arr[1],
                },
                url: '/action.php',
                onsuccess: function (success) {
                    if (success > 0) {
                        if (BX('auth_is').value == 'true') {
                            name = "Ваш комментарий";
                        }
                        ;
                        console.log(BX('auth_is').value);
                        if (flag == false) {
                            let comm = document.createElement('li');
                            comm.innerHTML = `<div class="block_com" id="${success}-${arr[1]}">
                    <div class="wrap-bl">
                        <div class="name">${name}</div>
                    <div class="date">${date} </div>
                    </div>
                    <div class="comments">${message}</div>
                    <a href="" class="ask scroll-to">Ответить</a>
                </div>`;
                            BX('list_comments').append(comm);
                        } else {
                            let id_parent = arr[1] + "-" + arr[2];
                            let comm2 = BX(id_parent);
                            if (comm2.parentElement.childNodes.length != 1) {
                                let comm = document.createElement('li');
                                comm.innerHTML = `<div class="block_com" id="${success}-${arr[1]}">
                    <div class="wrap-bl">
                        <div class="name">${name}</div>
                    <div class="date">${date}</div>
                    </div>
                    <div class="comments">${message}</div>
                    <a href="" class="ask scroll-to">Ответить</a>
                </div>`;
                                comm2.parentElement.lastChild.append(comm);
                            } else {
                                let comUl = document.createElement('ul');
                                comUl.innerHTML = `<li><div class="block_com" id="${success}-${arr[1]}">
                    <div class="wrap-bl">
                        <div class="name">${name}</div>
                    <div class="date">${date}</div>
                    </div>
                    <div class="comments">${message}</div>
                    <a href="" class="ask scroll-to">Ответить</a>
                </div></li>`;

                                comm2.parentElement.append(comUl);
                                console.log(comm2.parentElement);
                            }

                        }

                        alert('Ваше комментарий  успешно добавлен');
                        flag = false;
                        btn_del.style.display = 'none';
                        document.querySelector('#message').value = "";
                        document.querySelector('.hide_id').value = arr[0] + "-";

                    }

                },
                onfailure: function (error) {
                    console.log(error);
                }
            });
        } else {
            alert("Заполните все данные для комментария");
        }


    });
</script>


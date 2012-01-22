<?php

// Экспедиции.

// Загрузить настройки экспедиции.
function LoadExpeditionSettings ()
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."exptab;";
    $result = dbquery ($query);
    return dbarray ($result);
}

// Ничего не произошло.
function Exp_NothingHappens ($queue, $fleet_obj, $fleet, $origin, $target)
{
    $msg = array (
        'Экспедиция не принесла ничего особого, кроме какой-то странной зверушки с неизвестной болотной  планеты.',
        'Несмотря на первые многообещающие сканы этого сектора, мы возвращаемся с пустыми руками.',
        'Неполадка в реакторе ведущего корабля чуть не уничтожила всю экспедицию. К счастью техники предотвратили самое страшное, но ремонт занял много времени, и экспедиции пришлось вернуться с пустыми руками.',
        'Жизненная форма, состоящая из чистой энергии заставила членов экспедиции несколько дней подряд смотреть на гипнотирующие узоры на мониторах. Когда же большинство вышло из гипноза,  экспедиции надо было возвращаться, т.к. были исчерпаны все запасы дейтерия.',
        'Ваша экспедиция в прямом смысле слова познакомилась с вселенской пустотой. Ни единого астероида, ни единого излучения  или частички, хоть чего-нибудь, из-за чего стоило лететь.',
        'Ваша экспедиция сделала замечательные снимки сверхновой звезды, однако по-настоящему нового она ничего не принесла. Но тем не менее есть все шансы занять первое место на конкурсе за снимок года во вселенной.',
        'Ну по крайней мере мы теперь знаем, что красные аномалии 5-го класса не только вносят хаос в работу бортовых систем, но также вызывает массовые галлюцинации у экипажа. Но больше ничего нового экспедиция не принесла.',
        'Вскоре после выхода за пределы солнечной системы неизвестный компьютерный вирус парализовал систему навигации. Это привело к тому, что флот всё время пролетал кругом. Не стоит говорить, что экспедиция не удалась.',
        'Думаю не стоило всё-таки отмечать день рождения капитана на этой затерянной планете. Инопланетная лихорадка заставила большинство команды провести всю экспедицию в больничном отсеке. Резкая нехватка персонала привела к провалу экспедиции.',
        'Ваш экспедиционный флот следовал некоторое время странным сигналам. В конце концов эти сигналы привели его к древнему зонду, отправленному несколько поколений назад, чтобы поПРЕВЕДствовать другие цивилизации. Зонд был доставлен на борт и многие музеи с Вашей главной планеты уже выразили интерес в его приобретении.',
        'Ваш экспедиционный флот попал в опасную близость  гравитационного поля нейтронной звезды, и ему пришлось потратить некоторое время, чтобы выбраться из него. Это стоило флоту всего дейтерия, и поэтому экспедиция возвращается обратно с пустыми руками.'
    );

    // Вернуть флот.
    // В качестве времени полёта используется время удержания.
    DispatchFleet ($fleet, $origin, $target, 115, $fleet_obj['deploy_time'], $fleet_obj['m'], $fleet_obj['k'], $fleet_obj['d'], 0, $queue['end']);

    $n = mt_rand ( 0, count($msg) - 1 );
    return $msg[$n];
}

// Сообщение бортового инженера (счетчик посещений)
function BoardEngineerReport ($expcount, $exptab)
{
    $msg_1 = array (
        'Бортовой журнал, дополнение связиста: Эта часть вселенной наверное ещё не исследована.',
        'Бортовой журнал, дополнение связиста: Это такое возвышающее чувство - быть первопроходцем в неисследованном секторе вселенной.'
    );
    $msg_2 = array (
        'Бортовой журнал, дополнение связиста: Похоже, что в этом районе галактики ещё не ступала нога человека.',
        'Бортовой журнал, дополнение связиста: Мы обнаружили очень древние корабельные сигнатуры. Похоже, что мы тут не первые.',
        'Бортовой журнал, дополнение Связиста: Мы почти столкнулись с другим экспедиционным флотом. Никогда бы не подумал, что сюда ещё кто-то полетит.'
    );
    $msg_3 = array (
        'Бортовой журнал, дополнение связиста: Обнаружены следы присутствия других экспедиционных флотов.',
        'Бортовой журнал, дополнение связиста: Налажен дружеский радио-контакт с другими экспедициями из этого сектора.',
        'Бортовой журнал, дополнение связиста: Мы отпраздновали окончание экспедиции с членами команды повстречавшейся нам второй экспедиции, которая тоже исследовала этот сектор. Они тоже не нашли ничего особенного.'
    );
    $msg_4 = array (
        'Бортовой журнал, дополнение связиста: Если мы не слишком уверены в себе, то мы можем совместить усилия с остальными экспедициями из этого сектора.',
        'Бортовой журнал, дополнение связиста: Если так пойдёт и дальше, то при таком движении надо будет ставить навигационные буйки.',
        'Бортовой журнал, дополнение связиста: Может было бы разумнее соорудить здесь сувенирную станцию, вместо того, чтобы отправлять целую экспедицию?'
    );

    if ( $expcount <= $exptab['depleted_min'] ) {
        $n = mt_rand ( 0, count($msg_1) - 1 );
        return $msg_1[$n];
    }
    else if ( $expcount <= $exptab['depleted_med'] ) {
        $n = mt_rand ( 0, count($msg_2) - 1 );
        return $msg_2[$n];
    }
    else if ( $expcount <= $exptab['depleted_max'] ) {
        $n = mt_rand ( 0, count($msg_3) - 1 );
        return $msg_3[$n];
    }
    else {
        $n = mt_rand ( 0, count($msg_4) - 1 );
        return $msg_4[$n];
    }
}

// ------------- 
// Удачные события экспедиции

// Встреча с чужими
function Exp_BattleAliens ($queue, $fleet_obj, $fleet, $origin, $target)
{
}

// Встреча с пиратами
function Exp_BattlePirates ($queue, $fleet_obj, $fleet, $origin, $target)
{
}

// Нахождение Тёмной материи
function Exp_DarkMatterFound ($queue, $fleet_obj, $fleet, $origin, $target)
{
}

// Потеря всего флота
function Exp_LostFleet ($queue, $fleet_obj, $fleet, $origin, $target)
{
    $msg = array (
        'От экспедиции осталось только следующее сообщение: ".... о боже! Оно ... похоже ..... на ... "',
        'Раздробление ядра ведущего корабля вызвало цепную реакцию, которая довольно-таки эффектным взрывом уничтожила всю экспедицию.',
        'Последнее, что удалось получить от экспедиции, были невероятно хорошо получившиеся снимки открывающейся чёрной дыры крупным планом.',
        'Экспедиционный флот не вернулся из прыжка, и наши учёные теперь ломают над этим голову, но всё указывает на то, что с флотом можно распрощаться навсегда.'
    );

    // Флот возвращать не нужно...

    $n = mt_rand ( 0, count($msg) - 1 );
    return $msg[$n];
}

// Задержка возврата экспедиции
function Exp_DelayFleet ($queue, $fleet_obj, $fleet, $origin, $target)
{
}

// Ускорение возврата экспедиции
function Exp_AccelFleet ($queue, $fleet_obj, $fleet, $origin, $target)
{
}

// Нахождение ресурсов
function Exp_ResourcesFound ($queue, $fleet_obj, $fleet, $origin, $target)
{
}

// Нахождение кораблей
function Exp_FleetFound ($queue, $fleet_obj, $fleet, $origin, $target)
{
}

// Нахождение Скупщика
function Exp_TraderFound ($queue, $fleet_obj, $fleet, $origin, $target)
{
}

// -------------

function ExpeditionArrive ($queue, $fleet_obj, $fleet, $origin, $target)
{
    // Запустить задание удержания на орбите.
    // Время удержания сделать временем полёта (чтобы потом его можно было использовать при возврате флота)
    DispatchFleet ($fleet, $origin, $target, 215, $fleet_obj['deploy_time'], $fleet_obj['m'], $fleet_obj['k'], $fleet_obj['d'], 0, $queue['end'], 0, $fleet_obj['flight_time']);
}

function ExpeditionHold ($queue, $fleet_obj, $fleet, $origin, $target)
{
    $exptab = LoadExpeditionSettings ();

    $hold_time = 1;

    // Событие экспедиции.
    $chance = mt_rand ( 0, 99 );
    if ( $chance < ($exptab['chance_success'] + $hold_time) )
    {
        $expcount = $target['m'];    // счётчик посещений
        if ( $expcount <= $exptab['depleted_min'] ) $chance_depleted = 0;
        else if ( $expcount <= $exptab['depleted_med'] ) $chance_depleted = $exptab['chance_depleted_min'];
        else if ( $expcount <= $exptab['depleted_max'] ) $chance_depleted = $exptab['chance_depleted_med'];
        else $chance_depleted = $exptab['chance_depleted_max'];
        
        $chance = mt_rand ( 0, 99 );
        if ($chance >= $chance_depleted)    // Удачная экспедиция.
        {
            if ( $chance >= $exptab['chance_alien'] ) $text = Exp_NothingHappens/*Exp_BattleAliens*/ ($queue, $fleet_obj, $fleet, $origin, $target);
            else if ( $chance >= $exptab['chance_pirates'] ) $text = Exp_NothingHappens/*Exp_BattlePirates*/ ($queue, $fleet_obj, $fleet, $origin, $target);
            else if ( $chance >= $exptab['chance_dm'] ) $text = Exp_NothingHappens/*Exp_DarkMatterFound*/ ($queue, $fleet_obj, $fleet, $origin, $target);
            else if ( $chance >= $exptab['chance_lost'] ) $text = Exp_LostFleet ($queue, $fleet_obj, $fleet, $origin, $target);
            else if ( $chance >= $exptab['chance_delay'] ) $text = Exp_NothingHappens/*Exp_DelayFleet*/ ($queue, $fleet_obj, $fleet, $origin, $target);
            else if ( $chance >= $exptab['chance_accel'] ) $text = Exp_NothingHappens/*Exp_AccelFleet*/ ($queue, $fleet_obj, $fleet, $origin, $target);
            else if ( $chance >= $exptab['chance_res'] ) $text = Exp_NothingHappens/*Exp_ResourcesFound*/ ($queue, $fleet_obj, $fleet, $origin, $target);
            else if ( $chance >= $exptab['chance_fleet'] ) $text = Exp_NothingHappens/*Exp_FleetFound*/ ($queue, $fleet_obj, $fleet, $origin, $target);
            else $text = Exp_NothingHappens/*Exp_TraderFound*/ ($queue, $fleet_obj, $fleet, $origin, $target);
        }
        else $text = Exp_NothingHappens ($queue, $fleet_obj, $fleet, $origin, $target);
    }
    else $text = Exp_NothingHappens ($queue, $fleet_obj, $fleet, $origin, $target);

    // Обновляем счётчик посещений экспедиции на планете.
    AdjustResources ( 1, 0, 0, $target['planet_id'], '+' );

    // Бортовой журнал, дополнение связиста
    if ( $fleet[210] > 0 ) $text .= "\n<br/><br/>" . BoardEngineerReport ( $expcount, $exptab);

    SendMessage ( $fleet_obj['owner_id'], "Командование флотом", "Результат экспедиции [".$target['g'].":".$target['s'].":".$target['p']."]", $text, 3, $queue['end']);
}

// Посчитать количество активных экспедиций у выбранного игрока.
function GetExpeditionsCount ($player_id)
{
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."fleet WHERE (mission = 15 OR mission = 115 OR mission = 215) AND owner_id = $player_id;";
    $result = dbquery ($query);
    return dbrows ($result);
}

?>
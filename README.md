# bitrix-collection
Класс для работы с файлами. 
Помогает получить файлы одним запросом
Пример работы:
«`php
$list = []; // массив с элементами инфоблока
$list [
    ['ID' => 1, 'NAME' => 'name', 'PREVIEW_PICTURE' = 1],
    ['ID' => 2, 'NAME' => 'name', 'PREVIEW_PICTURE' = 2],
    ['ID' => 3, 'NAME' => 'name', 'PREVIEW_PICTURE' = 3]
];

//передача в объект массива $list и ключа содержащего id файла чтобы получить id всех файлов для выборки
$collectionImage = new FileCollection();
$paths = $collectionImage->setArrElements($list, 'PREVIEW_PICTURE') //второй аргумет метода принимает ключ поля из массива элементов содержащий id файла
                         ->getList();
«`
                         
Так же можно просто передать на вход метода getList готовый массив идентификаторов для выборки
$ids = [1, 2, 3];
$collectionImage = new FileCollection();
$paths = $collectionImage->getList($ids);

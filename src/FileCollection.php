<?php

class FileCollection
{
    /** @var array */
    public $arElements = [];

    /** @var string */
    public $nameFieldWithId = '';

    /** @var array */
    public $filter = [];

    /**
     * @param array $arr
     * @param string $nameFieldWithId название поля где хранится id картинки
     */
    public function setArrElements(array $arr, string $nameFieldWithId)
    {
        if (empty($arr) || empty($nameFieldWithId)) {
            return false;
        }

        $this->arElements = $arr;
        $this->nameFieldWithId = $nameFieldWithId;

        return $this;
    }

    public function filter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    public function buildFilter(array $ids = [])
    {
        $nameField = $this->nameFieldWithId;
        $arElements = $this->arElements;
        if (! empty($arElements) && ! empty($nameField)) {
            foreach ($arElements as $arElement) {
                $ids[] = $arElement[$nameField];
            }
        }

        $filter = count($ids) > 1 ? ['@ID' => implode(',', $ids)] : ['ID' => $ids[0]];
        if (!empty($this->filter) && is_array($this->filter)) {
            $filter = array_merge($filter, $this->filter);
        }

        return $filter;
    }

    public function getList(array $ids = [], bool $withInfo = false)
    {
        $paths = [];
        $result = \CFile::GetList([], $this->buildFilter($ids));
        while($element = $result->GetNext()) {
            if ($withInfo) {
                $paths[$element['ID']]['FULL_PATH'] = '/upload/' . $element['SUBDIR'] . '/' . $element['FILE_NAME'];
                $paths[$element['ID']] = array_merge($paths[$element['ID']], $element);
            } else {
                $paths[$element['ID']] = '/upload/' . $element['SUBDIR'] . '/' . $element['FILE_NAME'];
            }
        }

        return $paths;
    }
}

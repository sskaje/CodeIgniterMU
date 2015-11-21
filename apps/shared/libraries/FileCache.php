<?php

/**
 * PHP File Cache
 *
 * @author sskaje (https://sskaje.me/)
 */
class FileCache
{
    /**
     * key转文件名
     *
     * @param string $key
     * @return string
     */
    protected function key2path($key)
    {
        return CACHEPATH . '/' . $key . '.php';
    }

    /**
     * 写缓存
     *
     * @param string $key
     * @param mixed $value
     * @return int
     */
    public function set($key, $value)
    {
        $file = $this->key2path($key);
        return $this->_set($file, $value);
    }

    /**
     * 取缓存
     *
     * @param string $key
     * @return bool|mixed
     */
    public function get($key)
    {
        $file = $this->key2path($key);

        if (!$this->_exists($file)) {
            return false;
        }
        return $this->_get($file);
    }

    /**
     * 判断文件是否存在
     *
     * @param string $key
     * @return bool
     */
    public function exists($key)
    {
        return $this->_exists($this->key2path($key));
    }

    /**
     * 写文件
     *
     * @param string $file
     * @param mixed $value
     * @return int
     */
    private function _set($file, $value)
    {
        $content = "<?php\n".'return  ' . var_export($value, true) . ';';
        return file_put_contents($file, $content);

    }

    /**
     * 读文件
     *
     * @param string $file
     * @return mixed
     */
    private function _get($file) {
        return include($file);
    }

    /**
     * 判断文件是否存在
     *
     * @param string $file
     * @return bool
     */
    private function _exists($file)
    {
        return is_file($file);
    }
}

# EOF
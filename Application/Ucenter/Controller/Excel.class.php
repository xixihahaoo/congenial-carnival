<?php
/**
 * 生成excel文件操作
 *
 * @author wesley wu
 * @date 2013.12.9
 */
namespace Ucenter\Controller;
use Think\Controller;
class Excel extends Controller {
     
    private $limit = 10000;
     
    public function download($data, $fileName)
    {
        $fileName = $this->_charset($fileName);
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: inline; filename=\"" . $fileName . ".xls\"");
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
            <Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
            xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
            xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
            xmlns:html=\"http://www.w3.org/TR/REC-html40\">";
        echo "\n<Worksheet ss:Name=\"" . $fileName . "\">\n<Table>\n";
        $guard = 0;
        foreach($data as $v)
        {
            $guard++;
            if($guard==$this->limit)
            {
                ob_flush();
                flush();
                $guard = 0;
            }
            echo $this->_addRow($this->_charset($v));
        }
        echo "</Table>\n</Worksheet>\n</Workbook>";
    }
     
    private function _addRow($row)
    {
        $cells = "";
        foreach ($row as $k => $v)
        {
            $cells .= "<Cell><Data ss:Type=\"String\">" . $v . "</Data></Cell>\n";
        }
        return "<Row>\n" . $cells . "</Row>\n";
    }
     
    private function _charset($data)
    {
        if(!$data)
        {
            return false;
        }
        if(is_array($data))
        {
            foreach($data as $k=>$v)
            {
                $data[$k] = $this->_charset($v);
            }
            return $data;
        }
        return iconv('utf-8', 'utf-8', $data);
    }
     
}


?>
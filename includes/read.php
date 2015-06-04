<?php
header("Content-Type:text/html; Charset=utf-8");
?>
<style>
  p {
    font-size: 22px;
    font-style: italic;
    text-align: center;
    font-weight: bold;
    margin: 0;
  }
  table {

  }
  table tr:nth-child(2n) {
    background-color: rgb(207, 207, 207);
  }
  table tr:nth-child(2n+1) {
    background-color: rgb(230, 230, 250);
  }
</style>
<?php
/*$base_memory_usage = memory_get_usage();
function memoryUsage($n, $usage, $base_memory_usage)
{
	printf("Bytes diff: %d\n", $usage-$base_memory_usage);
	print "   Step: " . $n . "<br />";
}
memoryUsage(1, memory_get_usage(), $base_memory_usage);
echo memory_get_usage() . "<br>";*/
echo "<p>Расписание занятий</p>";
$filepath = "/var/www/wp-content/plugins/bulletin_board/tmp/file.xls";
//echo $filepath;
require_once "/var/www/wp-content/plugins/bulletin_board/includes/PHPExcel.php"; //подключаем наш фреймворк
if (file_exists($filepath)) {
	$inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
/*	$objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
	$objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
	$objPHPExcel->setActiveSheetIndex(0);
	// Получаем активный лист
	$sheet = $objPHPExcel->getActiveSheet();*/
    echo "<hr>";

    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcelReader = $objReader->load($filepath);

$loadedSheetNames = $objPHPExcelReader->getSheetNames();

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcelReader, 'HTML');

    $objWriter->setSheetIndex(0);
    $objWriter->save('table.html');

/*	function excel2mysql($worksheet, $columns_name_line = 0) {
    // Строка для названий столбцов таблицы MySQL
    $columns_str = "";
    // Количество столбцов на листе Excel
    $columns_count = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());

    echo $columns_count;

    echo "<hr>";
	
	echo "<table>";

        for ($row = $columns_name_line + 1; $row <= $worksheet->getHighestRow(); $row++) {
          // Строка со значениями всех столбцов в строке листа Excel
          $value_str = "";
          echo "<tr style='border: 1px solid;'>";
          // Перебираем столбцы листа Excel
          for ($column = 0; $column < $columns_count; $column++) {
            // Строка со значением объединенных ячеек листа Excel
            $merged_value = "";
            // Ячейка листа Excel
            $cell = $worksheet->getCellByColumnAndRow($column, $row);


            // Перебираем массив объединенных ячеек листа Excel
            foreach ($worksheet->getMergeCells() as $mergedCells) {
              // Если текущая ячейка - объединенная,
              if ($cell->isInRange($mergedCells)) {
                // то вычисляем значение первой объединенной ячейки, и используем её в качестве значения
                // текущей ячейки
                $merged_value = $worksheet->getCell(explode(":", $mergedCells)[0])->getCalculatedValue();
                break;
              }
            }

           // var_dump($merged_value);

            // Проверяем, что ячейка не объединенная: если нет, то берем ее значение, иначе значение первой
            // объединенной ячейки
            $value_str .= "'" . (strlen($merged_value) == 0 ? $cell->getCalculatedValue() : $merged_value) . "',";

          }

          // Обрезаем строку, убирая запятую в конце
          $value_str = substr($value_str, 0, -1);
 echo "<td style='border: 1px solid;'>";
          echo $value_str;
          echo "</td></tr>";
        }
echo "</table>";
        // Если всё хорошо, возвращаем true, иначе false
}

// Загружаем файл Excel
$PHPExcel_file = PHPExcel_IOFactory::load($filepath);

// Преобразуем первый лист Excel в таблицу MySQL
$PHPExcel_file->setActiveSheetIndex(0);
echo excel2mysql($PHPExcel_file->getActiveSheet(), 1) ? "OK\n" : "FAIL\n";
*/

/*!!!*/
 /* 
  echo "<table>";

  $arr = array('                                               РАСПИСАНИЕ','                                                                                             УЧЕБНЫХ  ЗАНЯТИЙ  ФАКУЛЬТЕТА КОМПЬЮТЕРНЫХ НАУК', '                                                                                              НА ВТОРОЕ ПОЛУГОДИЕ    2012/2013   УЧЕБНОГО ГОДА');

  // Получили строки и обойдем их в цикле
  $rowIterator = $sheet->getRowIterator();
  foreach ($rowIterator as $row) {
      // Получили ячейки текущей строки и обойдем их в цикле
      $cellIterator = $row->getCellIterator();

      echo "<tr style='border: 1px solid;'>";
          
      foreach ($cellIterator as $cell) {

        foreach ($sheet->getMergeCells() as $mergedCells) {
              // Если текущая ячейка - объединенная,
              if ($cell->isInRange($mergedCells)) {
                // то вычисляем значение первой объединенной ячейки, и используем её в качестве значения
                // текущей ячейки
                $merged_value = $sheet->getCell(explode(":", $mergedCells)[0])->getCalculatedValue();
                break;
              }
            }
            // if (!preg_match("#.*(\d+)\s*-\s*(\d+).*#siU", $merged_value, $time)) {
            //   $val = strlen($merged_value) == 0 ? $cell->getCalculatedValue() : $merged_value;
            // } 
            // else {
            //   $sub_str1 = substr($time[1], -2);
            //   $sub_str2 = substr($time[2], -2);
            //   $str1 = substr_replace($time[1], ":".$sub_str1, -2);
            //   $str2 = substr_replace($time[2], ":".$sub_str2, -2);
            //   $val = $str1."-".$str2;
            // }
           
            if (!preg_match("#\s*\d+\s*-\s*\d+\s*#siU", $merged_value)) {
              $val = strlen($merged_value) == 0 ? $cell->getCalculatedValue() : $merged_value;
            } 
            else {
              if ($cell->getCalculatedValue() != "") {
                $str = str_replace(' ', '', $cell->getCalculatedValue());
                $str = explode('-', $str);
                $sub_str1 = substr($str[0], -2);
                $sub_str2 = substr($str[1], -2);

                $str1 = substr_replace($str[0], ":".$sub_str1, -2);
                $str2 = substr_replace($str[1], ":".$sub_str2, -2);
                $val = $str1."-".$str2;
              } 
              else {
                $val = $cell->getCalculatedValue();
              }
            }
           // $val = $cell->getCalculatedValue();
            if (!in_array($val, $arr)) {
            	echo "<td style='border: 1px solid;'>" . $val . "</td>";
            	//echo "<td style='border: 1px solid;'>" . $cell->getCalculatedValue() . "</td>";
            }
            else {
            	break;
            }
	        //echo "<td style='border: 1px solid;'>" . $cell->getCalculatedValue() . "</td>";
	    }
	    
	    echo "</tr>";
	}
	echo "</table>";*/
/*!!!!*/
}
echo "string";
echo memory_get_usage() . "<br>";

�������� PDF � HTML

http://mpdf1.com/manual/index.php?page=introduction


======================================================
include('../mpdf.php');
$mpdf=new mPDF();
$mpdf->WriteHTML('<p>Hallo World</p>');
$mpdf->Output();
exit;
======================================================


$mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*������ ������, ������� �.�.�.*/
$mpdf->charset_in = 'cp1251'; /*�� �������� ��� �������*/

$stylesheet = file_get_contents('style.css'); /*���������� css*/
$mpdf->WriteHTML($stylesheet, 1);

$mpdf->list_indent_first_level = 0; 
$mpdf->WriteHTML($html, 2); /*��������� pdf*/
$mpdf->Output('mpdf.pdf', 'I');

======================================================


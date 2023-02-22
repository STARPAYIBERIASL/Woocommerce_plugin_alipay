<?php

require_once('StarPayAlipayPlusAPI.php');
require_once('StarPayAlipayPlusUtils.php');
require_once('StarPayAliapayPlusConfig.php');
//require_once('QrcodeUtil.php');
$config = StarPayAliapayPlusConfig::getInstance();

use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\Response\QrCodeResponse;


//$config->setACCESSID('A10000008');
//$config->setMCHACCESSNUMBER('B10000003');
//$config->setVERSION('1.0');
//$config->setSECRETKEY('-----BEGIN RSA PRIVATE KEY-----
//MIIEpQIBAAKCAQEArUnMyHs3llZgxNQ8cJf7zsDvNAC/jKWFn/2N/bqMy588Ja6u
//AP3+Y2pjmAWWvXqybkVxvl9VSwqiz4ymexzjTcbip0xFlzmPL9yfvrCj5H4JFkjw
///LA73XPSeTIe1r0jhPlOUGKf7chEqp3m9rSrkPgpyQWWSQJrJu4nGk8CqgSnSQkB
//4LnuXnSwxJf4bGf+ybTsXV8M2wEu5/btUKe/eUmVCEWce8+qfUj2LoqC1gC1RT5x
//bTWEiLUH7SRdOt853/5XVVYtdwgN93fZHfY4CAAUJp6fN4DG3N+5XRgirnlt1CKn
//fE1mOLlNBnW9SkVJGnXaso7cXcVNEAKQGXGu1QIDAQABAoIBAQCdLiSu8HzyQ3VQ
//88XCx0jjN8OA4vDcLUMwZLfHns+Y3t2avIAebESzfkvKF7+sLL/uH9VVPXnLMGGP
//at+TKhfPc4ghAaDZ057aZf8L44M1fVDWwuC8A0q5yxXtUpYAZ9zw/4WWim7QKuiF
//7eYSfrxkKYUVTpkLrkLtM/WJ+oLLHSFBzFrA1rrvwDFQSaTmqcUXTw7W980eDMDm
//4gENbOttiWr4IOgdU8dEWTpH3OE4kOwVM6bKrFavTmQrbjGJijsAyz8aoRNmuwSS
//ZUnRacabI0B/0y4FMEwdC9yjfGhuMdG56WVcq+GhGKoAwtT/mBw9rUUjTOFM5ZAU
//xNBgKURdAoGBANeGG0dyrQkHiHkY7+C4n5ImmDpbc8qo2vWJtmHw8bEy4aqMGiN9
//T34/OYBkxxTcv5RcobaHipB26welR2+1OYknYCrl6qXBIMRjdkKWWkMKZqO9k7dX
//giiHKifTZQzqFs9HRsHDN79rsVIyVsgZ+RTrQFOgn6bLgP7I+zOlF0M7AoGBAM3V
//Go56FcBBEiuebniFDNfC1C6MD2gwQUg0pKLsnZ8Np88xQAj+cw+veoV2omGRqkpg
//Gxq5WVkTYdQ+QggdqLyq086j4Y3RaV5JTUqEVogjzY7V3olassnOtYoq/9cVWcdH
//KXpRi+7CImvZ1QHvH2MEvqonFWR2JV0YPk2JcZUvAoGBAJL/Eb4CdghxjeBiZMGV
//yqgpEKzE0U4JKwZLPgzBBGfCd24WDoHkJwLJZpOuqKYPBc/P+i//dD+iDB1z2ixT
//o4FrTMkVdZxGA+5OlEtINxoAjw7g704eLlUsE1GEeih7xMDtMVJYrr4tWozgbpYe
//OOfOqFohdKKTrFCajdKkqCAfAoGALekspT8B/wIEpYoPJf63YKDqZv+CqECrLwne
//9yBEACgxl/tqRxdKXuNLNt3BVnYBP9mz8gAJt96k4YyJefnzmzGXUO4o71MYZ5l+
//DfL6wh8KSKPXoVeDrZPX1lvE+RqgDd0HmWr7BWRz/Q53fpjxrUpvpNBW6zOXHe68
//ZtsTZK0CgYEAlPm0SNNBxUMCrKQ8xtTXVU8/puJLe1DJB39qwxRu1qWHKOndjHtq
//R0AZySXm6TtEBwbWUzlquKGfKJaycVxt46yAnOGj/oR/ojgZRaeVc/H7JLK67tOj
//JMvYD9CTRaDtJjVGwkbK/wCDHbgXmngdACeTmoTy+Clu4ZfAtmMsMKM=
//-----END RSA PRIVATE KEY-----
//');
$config->setACCESSID('A10000074');
$config->setMCHACCESSNUMBER('B10000220');
$config->setVERSION('1.0');
$config->setSECRETKEY('-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAqsqqk85I2a10MltG5jM/5jnea5Q3qAsPRn8oFNJXfP4IsQU9DkX1Hem5uFbcCmWe8GCHJzAR75nGB3gqr1OrebKxdAvLJydPb/8NfAWL7+Gwuhc53GpY9RvQn12jEM6UC8iDLjJp+P/S437CWeILCHB2AXLQT4wVeLhgfiqP6RQv5DjwGCqf8Mr4znntqPeYltEdOEGWaGwBG8tIC4n/XtwdN718th7tnUy8VLE34kgfroVM0k8xwihJPKju3CaRjXyYtZ/jYhJEL8av9J8MQwuNRSf3W3TUQj7CFjRVuJNIa0GXI3UVMwX/p494iibMBP/HCpgPmPbdLHNz6feqZQIDAQABAoIBAQCdMYFEHuXgK4w52Nbtgxf57yMuwrFjIiLCEMC0QVCywyD+xMKIQ40yJe+AoblOfG+H8GAUimLHszGXqFspGYpGrVg0ZbJqa/zqKMahcn10oLXG4R+pJdyQZDRkqYsvKeMK4VcTiuUMf3D7X6zDi4/6CYAjHyhpPpZ4kMKG/OeNbjrNsceqfbFRg2Cnw0d0LCGk8+m8IqK0RPOSOdIOyCQzDaH1s6ccGp7hfsLErXITf6oONgBUv6db8gxAwYWdZJ3lILBaIFrNQoracRZt1ukGDkLoEXUyl4JmUtbVfHz7wpvOv563ta0+cSkIblvGf+Gvu8su+6+2qoYpMWAtS3ohAoGBAOmQNDwqsKhcDmBsefwxvbK1wWNYv66vL8wM0cfKZIdZ7iTYYmVBUV/1g9U3J1BAxoSq94JBBjPa28xMV9LqrTjTCWzuI0KK03tMtomtEJxgAPrbVqudmitC9+W9F3ecSga+AxAokM4Gxc5PxAtmoo6hPTbZwaSUwmRARMPRnC79AoGBALsyx8O11scnqQq9UxwXcVoooJqj+U4gLFBTezMV7YXtJXY3mUXUDwgKxpaxKQ9HjtCn1q1cVN7fUXG+XnN3Kp8b/m0sU/P/RANR4HjKFz8Lv+A6QbD4w3ZAS6FkUwZNE/2buh4nUCRe5wN+4qlysixFRt6Gbc5zMzD9kXR+DCmJAoGAP7tstXpEqDwuZBtVkf6Ur94uvggqjeUZ2skouSa+FbzxYbZ16wFOzit1ZMne/WQfh3YLgcxyf9XZoj62vEPzLo1PhhzZHEA7guqk6J6D6Ne9jLYrSTsBJYrpkBPwAmBwRrS0q0UWdlGcyjYz3ZSNCPRwerYiw+EfxjFPUkuxHZUCgYAbTR6hRmXaicg3jsEOOcUIVyCFLSDw6fRMisBPBQWtIJb0FMu/yVuf2qJ328KXPeJwP+opQmwGTR99rTvtLxYCOnzywyJDVZk/urM4KpEVWstTEmv+OWmYV2wwT4dkRd2CgTG1sBoaE9UxR1IbUGT32+qoDYb6MwbmQDT0fmWbsQKBgQCgimNt+reQwGmpd+IVrHTGc2eJSLQqnOSBjopoaBUygKl9uvMIPM16tfgjP5ujflZXJIzU7rJdUxoSRi89TeLH+yUFiZKu6NvmrQh99VTUSWsa/TBPEw8if8A4npMDvIbKrSU0ouCJnuXEpD0/74o9C5w3v11vqN+QhVkOjLQDpg==
-----END RSA PRIVATE KEY-----
');

$api = new StarPayAlipayPlusAPI();
//$result = $api->scanToPay('test-11-14-123', 0.01, 'yesy', 'http://c0bd850e.ngrok.io');
//echo $result['coreImgForBase64'];
$result = $api->scanToPay('20221216000036', 0.09, 'yesy', 'http://c0bd850e.ngrok.io');
$coreImgUrl = $result['content']['coreImgUrl'];
$coreUrl = $result['content']['coreUrl'];
echo $coreUrl;





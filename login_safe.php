<?php
$id = $_GET['id_box']; //GET 방식을 통해 전달된 id_box 변수에 있는 값을 저장함
$pw = $_GET['pw_box']; //GET 방식을 통해 전달된 pw_box 변수에 있는 값을 저장함

$db_conn = mysqli_connect("localhost", "webhacking", "webhacking", "login");//DB에 연결을 시도함(DB가 설치된 컴퓨터 주소, 아이디, 패스워드, 사용할 Database)
if(!$db_conn) // 만약 db_conn 변수에 아무것도 없다면(오류가 났다면)
{
	echo mysqli_connect_error(); // 연결시 나타나는 에러 확인
	echo "connect error"; // 에러가 났음을 화면에 출력해줌
	exit(); // PHP 강제 종료
}

$query = "select id from user where id=? and pw=?"; //실행시키고자 하는 쿼리를 준비, 유동적으로 변해야하는부분은 ?로 처리
$stmt = mysqli_prepare($db_conn, $query); //쿼리가 준비됬으면 ?부분을 채울 준비를 시킨다 
if($stmt == false)// 준비가 제대로 안돼면?
{
    echo('prepared statement failed : '.mysqli_error($db_conn));
    //에러 내용 출력
    exit();
    //종료
}

$bind = mysqli_stmt_bind_param($stmt, "ss", $id, $pw); 
// 준비까지 잘 됬다면, ?부분에 값을 넣을것인데 순서대로(준비된 쿼리, 어떤타입의 값이 몇개, 실제 넣을 값들1, 실제 넣을 값들2)
if($bind == false) //? 부분에 잘 값을 넣지 못했다면
{
    echo('binding failed : '.mysqli_error($db_conn));
    // 에러 내용 출력
    exit();
    // 종료
}

$exec = mysqli_stmt_execute($stmt); 
//잘 준비도 됬고, ?부분에 값도 넣었다면 쿼리를 실행 시킨다!
if($exec == false) // 실행에 실패했다면
{
    echo('execute failed : '.mysqli_error($db_conn)); 
    // 에러 내용 출력
    exit();
    // 종료
}


$result = mysqli_stmt_get_result($stmt); 
// 쿼리 잘 실행했으면, 결과값을 받아오자
if($result)// 받아와진 결과값이 무언가있다면
{
    if($row = mysqli_fetch_assoc($result))
    // 불러올 데이터가 있다면
    {
		echo "id = ".$row['id']; // 로그인 성공 시 화면에 아이디 출력
	}
	else
	{
		echo "login failed"; // 로그인 실패를 화면에 출력
	}
	mysqli_free_result($result);// 지금까지 사용한 결과값을 삭제해 주는 역할
	mysqli_stmt_close($stmt);// 다썼으면, 준비했던 쿼리도 삭제해서 공간 비우는 역할
}
else // 명령어 실행결과가 없을경우(필드명도 없을 경우)
{ 
	echo "query error"; // 명령문이 제대로 실행되지않았음을 화면에 출력함
}
mysqli_close($db_conn); //연결되어있던 Database 연결 해제
?>


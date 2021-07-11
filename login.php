<?php
$id = $_GET['id']; //GET 방식을 통해 전달된 id 변수에 있는 값을 저장함
$pw = $_GET['pw']; //GET 방식을 통해 전달된 pw 변수에 있는 값을 저장함

$db_conn = mysqli_connect("localhost", "root", "webhacking", "Dowan"); //DB에 연결을 시도함(DB가 설치된 컴퓨터 주소, 아이디, 패스워드, 사용할 Database)
if(!$db_conn) // 만약 db_conn 변수에 아무것도 없다면(오류가 났다면)
{
	echo mysqli_connect_error(); // 연결시 나타나는 에러 확인
	echo "connect error"; // 에러가 났음을 화면에 출력해줌
	exit(); // PHP 강제 종료
}

$query = "select id from user where id='".$id."' and pw='".$pw."'"; //select 조회문에 아까 GET방식으로 전달받은 id와 pw값을 문자열 더하기를 통해 하나의 명령문으로 만듬
$result = mysqli_query($db_conn, $query); // 연결되어있는 Database와(db_conn)에 미리 만들어둔 명령을 실행
echo "query : ".$query."<br>"; // 내가 만든 명령문이 잘 만들어졌는지 확인하기 위한 화면출력용 코드

$result_chk=0; // 로그인 성공 실패 여부 확인용 변수

if($result) // 결과가 있다면
{
	while($row = mysqli_fetch_assoc($result)) // 최종 조회 결과값의 한행씩 가져와 불러올 행일 없을때 까지 반복함
	{
		if($row) //불러온 행이 있다면
		{
			echo "id = ".$row['id']; // 로그인 성공 시 화면에 아이디 출력
			$result_chk=1; //로그인에 성공했기떄문에 확인용 변수를 1로 변경
		}
	}
	if($result_chk!=1) // 만약 확인용 변수가 1이 아니라면 즉 취약
	{
		echo "login failed"; // 로그인 실패를 화면에 출력
	}
	mysqli_free_result($result); // 지금까지 사용한 결과값을 삭제해 주는 역할
}
else // 명령어 실행결과가 없을경우(필드명도 없을 경우)
{ 
	echo "query error"; // 명령문이 제대로 실행되지않았음을 화면에 출력함
}
mysqli_close($db_conn); //연결되어있던 Database 연결 해제

?>





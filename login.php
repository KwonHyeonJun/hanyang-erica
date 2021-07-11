<?php
$id = $_GET['id_box'];
//GET 방식을 통해 전달된 id_box 변수에 있는 값을 저장함

$pw = $_GET['pw_box']; 
//GET 방식을 통해 전달된 pw_box 변수에 있는 값을 저장함

$db_conn = mysqli_connect("127.0.0.1", "webhacking", "webhacking", "login"); 
//DB에 연결을 시도함(DB가 설치된 컴퓨터 주소, 아이디, 패스워드, 사용할 Database)

if(!$db_conn) // 만약 db_conn 변수에 아무것도 없다면(오류가 났다면)
{
	echo mysqli_connect_error();
       	// 연결시 나타나는 에러 확인
	
	exit();
       	// PHP 강제 종료
}

$query = "select id from user where id='" . $id . "' and pw='" . $pw . "'";
//select 조회문에 아까 GET방식으로 전달받은 id와 pw값을 문자열 더하기를 통해 하나의 명령문으로 만듬

$result = mysqli_query($db_conn, $query);
// 연결되어있는 Database와(db_conn)에 미리 만들어둔 명령을 실행

echo "query : " . $query . "<br>";
// 내가 만든 명령문이 잘 만들어졌는지 확인하기 위한 화면출력용 코드

if($result) // 결과가 있다면
{
	if($row = mysqli_fetch_assoc($result))
	// 불러올 데이터가 있다면
	{
		echo "id = ".$row['id']; 
		// 로그인 성공 시 화면에 아이디 출력
	}
	else
	{
		echo "login failed";
	       	// 로그인 실패를 화면에 출력
	}

	mysqli_free_result($result);
       	// 지금까지 사용한 결과값을 삭제해 주는 역할
}
else // 명령어 실행결과가 없을경우(필드명도 없을 경우)
{ 
	echo "query error";
       	// 명령문이 제대로 실행되지않았음을 화면에 출력함
}

mysqli_close($db_conn);
//연결되어있던 Database 연결 해제

?>






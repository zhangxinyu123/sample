<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ע��ȷ������</title>
</head>
<body>
<h1>��л���� Sample ��վ����ע�ᣡ</h1>

<p>
    ����������������ע�᣺
    <a href="{{ route('confirm_email', $user->activation_token) }}">
        {{ route('confirm_email', $user->activation_token) }}
    </a>
</p>

<p>
    ����ⲻ�������˵Ĳ���������Դ��ʼ���
</p>
</body>
</html>
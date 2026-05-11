<!DOCTYPE html>
<html>
<head>
    <title>Redefinir Senha</title>
</head>
<body>
    <h1>Olá {{ $name }},</h1>
    
    <p>Você solicitou para redefinir sua senha. Clique no link abaixo para continuar:</p>
    
    <p>
        <a href="{{ $url }}" style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
            Redefinir Senha
        </a>
    </p>
    
    <p>Ou copie e cole o link abaixo no seu navegador:</p>
    <p>{{ $url }}</p>
    
    <p>Este link expirará em 1 hora.</p>
    
    <p>Se você não solicitou isso, ignore este e-mail.</p>
    
    <p>Atenciosamente,<br>Tunerz Team</p>
</body>
</html>

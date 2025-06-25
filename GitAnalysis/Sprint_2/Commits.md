# Commits by author
#### 1220893@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 DAL/login_dal.php      |    1 
 b/CSS/styleGlobal.css  |   72 -------------------------------------------------
 b/CSS/styleLogin.css   |   72 +++++++++++++++++++++++++++++++++++++++++++++++++
 b/DAL/login_dal.php    |    3 +!
 b/DAL/profile_dal.php  |    2 !
 b/UI/login.php         |    2 !
 b/bll/handle_login.php |    1 
 bll/handle_login.php   |    2 !
 8 files changed, 75 insertions(+), 73 deletions(-), 7 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 775580681753a26f3bf855d4e3bda4578ad49444	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Tue Jun 24 19:08:09 2025 +0100

    agora a passar pelo funcionario para dadosLogin

M	DAL/login_dal.php
M	DAL/profile_dal.php
M	bll/handle_login.php

commit 7bd5c9458dec60faacde84ab1f4b90dbcbd58d1c	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Tue Jun 24 17:57:38 2025 +0100

    update login

M	CSS/styleGlobal.css
A	CSS/styleLogin.css
M	DAL/login_dal.php
M	UI/login.php
M	bll/handle_login.php
</pre>

</details>

#### 1230650@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /BLL/equipaBLL.php        |   23 +++++++
 /DAL/equipaDal.php        |   20 ++++++
 DAL/connection.php        |   11 +!!
 DAL/login_dal.php         |    2 
 UI/Equipas.html           |    2 
 UI/equipas.php            |  136 ++++!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 UI/login.php              |    2 
 b/BLL/equipaBLL.php       |    2 
 b/BLL/handle_login.php    |    1 
 b/DAL/connection.php      |    1 
 b/DAL/equipaDal.php       |   51 ++++++++++++++!!!
 b/DAL/login_dal.php       |    2 
 b/UI/Equipas.html         |    1 
 b/UI/atualizarPerfil.html |    1 
 b/UI/equipas.php          |    2 
 b/UI/guest.html           |    1 
 b/UI/login.php            |    3 !
 b/UI/perfil.php           |    1 
 18 files changed, 105 insertions(+), 2 deletions(-), 155 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 251312fd96b02ffcbecaf81720cb79fc16157f3b	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 19:12:41 2025 +0100

    .

M	UI/perfil.php

commit 012faaceb4d07219456c4251d66bb1ad6b8467c8	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 19:11:22 2025 +0100

    .

M	DAL/connection.php
M	DAL/login_dal.php

commit 05a0df2051dd2e6eb70e695e3e324fa1b25b9fe2	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 18:40:10 2025 +0100

    mudanças pequenas visualização equipas

M	UI/equipas.php

commit 8bd65d8e3ebfa50f0746fcc16e4070bbb4c7a6b7	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 18:33:17 2025 +0100

    .

M	DAL/login_dal.php

commit cf17d0ac16f10760ffbc750ecb11f72ff25ec1d8	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 18:28:25 2025 +0100

    connection updates

M	BLL/handle_login.php
M	DAL/connection.php
M	UI/equipas.php
M	UI/login.php

commit 42bf8984fe04587525f77ada292a9fbacfa20f52	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 18:04:02 2025 +0100

    path correction

M	UI/login.php

commit 23cf68f365da562a5bb41194a807488179035841	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 18:03:35 2025 +0100

    path correction

M	UI/login.php

commit 4aaa655ea3b6c215d48fb8ffaa0a43cee4f8b59d	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 18:03:02 2025 +0100

    Mudanças no código da visualização de quipas

M	BLL/equipaBLL.php
M	UI/equipas.php

commit 7cdf7e0b8db86affe02d4df36d40352efa07d5d6	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 17:51:47 2025 +0100

    Mudanças no código da visualização de quipas

A	BLL/equipaBLL.php
M	DAL/connection.php
M	DAL/equipaDal.php
M	UI/equipas.php

commit 1637d7752367702682e72488075655bfbd32bf63	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 16:41:28 2025 +0100

    minor changes

A	DAL/equipaDal.php
R100	UI/Equipas.html	UI/equipas.php

commit 96ba3471aba488dd726e00b3171529ba674789d3	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 15:40:57 2025 +0100

    bll para BLL

R100	bll/handle_login.php	BLL/handle_login.php
R100	bll/perfil_bll.php	BLL/perfil_bll.php

commit 5f7d763e605f0bd775d8d861d799396d2bdb261a	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 12:22:14 2025 +0100

    path bug fixes

M	UI/Equipas.html
M	UI/atualizarPerfil.html
M	UI/guest.html

commit 093868cb68f78b5305c99531e1990d71a12443e9	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 11:57:06 2025 +0100

    .

M	UI/Equipas.html
</pre>

</details>

#### 1230794@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /BLL/criarEquipa_bll.php  |   23 +++++++++++
 /DAL/criarEquipa_dal.php  |   60 ++++++++++++++++++++++++++++++
 /DAL/perfil_dal.php       |   21 ++++++++++
 /UI/Permissoes.php        |   45 ++++++++++++++++++++++
 /UI/criarEquipa.php       |   26 +++++++++++++
 /UI/profile.php           |   75 +++++++++++++++++++++++++++++++++++++
 /profile_dal.php          |    2 +
 CSS/styleGlobal.css       |    2 !
 DAL/perfil_dal.php        |   54 ++++++++++++++++++++-!!!!
 DAL/profile_dal.php       |   23 -----------
 UI/Permissoes.php         |    6 -!!
 UI/perfil.php             |   90 +++++++++++---------------------------!!!!!!
 UI/profile.html           |   65 --------------------------------
 b/BLL/criarEquipa_bll.php |   37 ++++++++++++!!!!!!
 b/CSS/styleGlobal.css     |    5 +!
 b/DAL/criarEquipa_dal.php |   38 ------------!!!!!!!
 b/DAL/login_dal.php       |    1 
 b/DAL/perfil_dal.php      |    1 
 b/DAL/profile_dal.php     |   22 +++++++++++
 b/UI/Equipas.html         |    2 !
 b/UI/Permissoes.php       |   11 -!!!!
 b/UI/criarEquipa.php      |    3 -
 b/UI/logout.php           |   22 +++++++++++
 b/UI/perfil.php           |    2 !
 b/UI/profile.php          |   12 !!!!!!
 b/UI/updateProfile.html   |    1 
 b/bll/handle_login.php    |    1 
 b/bll/perfil_bll.php      |    2 !
 b/bll/profile_bll.php     |   19 +++++++++
 bll/perfil_bll.php        |   91 ++++++++++++++++++++++++++++++!!!!!!!!!!!!!!!!
 30 files changed, 470 insertions(+), 176 deletions(-), 116 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit c07831962dc53b4ec197d01ef81935393a0c1be4	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 18:16:48 2025 +0100

    criar equipa form

M	BLL/criarEquipa_bll.php
M	DAL/criarEquipa_dal.php
M	DAL/perfil_dal.php
M	UI/criarEquipa.php

commit 1f877b3bae4b5f6a26b974a4cb87352e2cc246bb	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 12:21:46 2025 +0100

    criarEquipa0.1

A	BLL/criarEquipa_bll.php
A	DAL/criarEquipa_dal.php
A	UI/criarEquipa.php

commit 89c1293495813356e0b4d60a4394eb999671907c	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 11:42:09 2025 +0100

    perfil

M	CSS/styleGlobal.css
M	UI/Permissoes.php
M	UI/perfil.php
M	bll/perfil_bll.php

commit 96360e1fc58e26e5d42923dc3fa98c1df4be3e07	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 10:01:05 2025 +0100

    funcao

M	DAL/login_dal.php
M	DAL/perfil_dal.php
M	UI/Permissoes.php
M	UI/perfil.php

commit 16da56e49950df76616744a3a0e616c72df3bef0	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 09:46:11 2025 +0100

    permissoes

M	UI/Permissoes.php

commit b5632730919410db62f229b08d0a828e1b0a9bb3	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 09:44:14 2025 +0100

    some changes

M	CSS/styleGlobal.css
M	UI/Equipas.html
A	UI/Permissoes.php
M	UI/perfil.php
M	bll/perfil_bll.php

commit f9c2db5569ec7eb1afa8c1fbb351234782ae7dd7	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 08:52:28 2025 +0100

    perfil completo

M	DAL/perfil_dal.php
M	bll/perfil_bll.php

commit 392d8a63a20ff606a33cec8578a9ab4966bcf2a3	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 08:42:58 2025 +0100

    perfil completo

M	DAL/perfil_dal.php
M	bll/perfil_bll.php

commit c5ae9188ed72adf29899a30ee8eff40d1d996a79	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 21:34:10 2025 +0100

    perfil 0.9

M	DAL/perfil_dal.php

commit 5c942cb89c51645c02111830a67a477450c573ff	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 21:23:51 2025 +0100

    logout

A	UI/logout.php
M	UI/perfil.php

commit 0c4cf3651c87f829bf7b023b78cbebf327c64170	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 21:05:57 2025 +0100

    perfil funcional

M	DAL/perfil_dal.php
M	UI/perfil.php
M	bll/perfil_bll.php

commit a2a35fb83606c32ab2afcb220baf0ceeadc571b0	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 20:42:19 2025 +0100

    perfil teste1

M	DAL/perfil_dal.php
M	UI/perfil.php
M	bll/perfil_bll.php

commit ffc32d522ff5ce90be4ef5d0e5d7a765428359f9	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 20:09:29 2025 +0100

    perfil change name

M	bll/handle_login.php
M	bll/perfil_bll.php

commit d4c82b68420024e3c70bf1c5137df31cd26fcdcd	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 20:05:39 2025 +0100

    Rename perfil dal bll

A	DAL/perfil_dal.php
D	DAL/profile_dal.php
R089	bll/profile_bll.php	bll/perfil_bll.php

commit 3382ab9a1fc8980acec0f70d0a066acc7c5e8141	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 15:41:44 2025 +0100

    some minor changes

M	UI/profile.php

commit fe12ec3d480d3e4ab038ccf4be56dbd9303cdce8	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 15:32:30 2025 +0100

    html to php

M	DAL/profile_dal.php
D	UI/profile.html
A	UI/profile.php
A	bll/profile_bll.php
D	bll/profile_dal.php

commit d84f61d9776e6a661f16b9246cbf194ae65ab2b3	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jun 24 15:17:13 2025 +0100

    something

A	DAL/profile_dal.php
M	UI/updateProfile.html
A	bll/profile_dal.php
</pre>

</details>

#### 1231060@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /DAL/registoFuncionario_dal.php    |  113 +++++++++++++++++++++++++++++++
 /UI/admin/registoFuncionario.html  |  133 +++++++++++++++++++++++++++++++++++++
 /UI/admin/registoFuncionario.php   |   18 +++++
 BLL/perfil_bll.php                 |    1 
 BLL/registoFuncionario_bll.php     |  101 ++++++++++-----!!!!!!!!!!!
 DAL/connection.php                 |    1 
 DAL/login_dal.php                  |    1 
 DAL/perfil_dal.php                 |   12 !!
 DAL/registoFuncionario_dal.php     |   96 ++++++++++++!!!!!!!!!!!!!!
 b/BLL/perfil_bll.php               |    1 
 b/BLL/registoFuncionario_bll.php   |   97 ++++++++++++++++++++-!!!!!
 b/CSS/styleAtualizarPerfil.css     |    3 
 b/CSS/styleLogin.css               |    2 
 b/DAL/connection.php               |    1 
 b/DAL/login_dal.php                |    1 
 b/DAL/perfil_dal.php               |    1 
 b/DAL/registoFuncionario_dal.php   |    4 
 b/UI/admin/admin.html              |   11 +++
 b/UI/admin/admin.php               |    1 
 b/UI/admin/registoFuncionario.html |   48 ++++++++++!!!
 b/UI/admin/registoFuncionario.php  |    1 
 b/UI/atualizarPerfil.html          |    1 
 b/UI/login.php                     |    1 
 23 files changed, 477 insertions(+), 26 deletions(-), 146 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 12f6edfafa5a7dbf1b2f8ec31b67057f11c61752	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jun 25 19:09:28 2025 +0100

    fix perfil
    
    fix minor bugs no perfil

M	BLL/perfil_bll.php
M	BLL/registoFuncionario_bll.php
M	DAL/connection.php
M	DAL/perfil_dal.php
M	DAL/registoFuncionario_dal.php

commit 7596b776bef7657c323344a175f2747a9b193252	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jun 25 18:40:55 2025 +0100

    fix bugs
    
    fix bugs do login e do perfil

M	BLL/perfil_bll.php
M	BLL/registoFuncionario_bll.php
M	DAL/connection.php
M	DAL/login_dal.php
M	DAL/perfil_dal.php

commit 22660b1b1be05f83121257f88e7c3120094d221a	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jun 25 18:04:07 2025 +0100

    registo de dados pessoais funcional
    
    registo de dados pessoais funcional

M	BLL/registoFuncionario_bll.php
M	DAL/registoFuncionario_dal.php

commit f351a7e546cae714cef2cce888e3ae748a9a5f20	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jun 25 13:29:35 2025 +0100

    Debug registoFuncionario
    
    Fix de alguns bugs do registo Funcionario

A	BLL/atualizarPerfil_bll.php
M	BLL/registoFuncionario_bll.php
M	DAL/registoFuncionario_dal.php

commit 3466632ede0312752026ac6905777eeaa18e389e	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jun 25 08:51:35 2025 +0100

    Fix de include

M	BLL/registoFuncionario_bll.php
M	DAL/login_dal.php
M	DAL/perfil_dal.php
M	DAL/registoFuncionario_dal.php
M	UI/admin/registoFuncionario.php

commit 3112b4b35fc8297cf008bad68ed269ae746a447a	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Tue Jun 24 23:15:05 2025 +0100

    Desenvolvimento registoFuncionario
    
    Desenvolvi o registo de funcionario (apenas para o admin)

R071	UI/admin/registoFuncionario.html	BLL/registoFuncionario_bll.php
M	DAL/perfil_dal.php
A	DAL/registoFuncionario_dal.php
R070	UI/admin/admin.html	UI/admin/admin.php
A	UI/admin/registoFuncionario.php

commit e9ff8929652b0e187db73e6c6a8a09a7d92ffb0c	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Tue Jun 24 21:32:58 2025 +0100

    Ajuste do registo de funcionario

M	UI/admin/registoFuncionario.html

commit 8b9e17e97fcf42483f3a7190407496e9e63730c0	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Tue Jun 24 19:01:10 2025 +0100

    Criação do formulário de registo de funcionario no admin

M	CSS/styleLogin.css
A	UI/admin/admin.html
A	UI/admin/registoFuncionario.html
M	UI/login.php

commit bc9a7ae9577452d286ea95870294c275cc71451c	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Tue Jun 24 18:06:21 2025 +0100

    href do atualizarPerfil

M	UI/atualizarPerfil.html

commit a44ec1e236032b643443dbec7d02ad2004bc14e5	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Tue Jun 24 16:28:55 2025 +0100

    Criação styleGlobal e styleAtualizarPerfil

A	CSS/styleAtualizarPerfil.css
R100	css/style.css	CSS/styleGlobal.css
R100	UI/updateProfile.html	UI/atualizarPerfil.html
R100	UI/profile.php	UI/perfil.php
</pre>

</details>


# Commits by author
#### 1220893@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /BLL/dashboard_bll.php                              |   15 
 /CSS/styleDashboard.css                             |   22 
 /CSS/styleLogin.css                                 |   72 
 /CSS/stylePerfil.css                                |   36 
 /DAL/dashboard_dal.php                              |   71 
 /UI/dashboard.php                                   |   19 
 /jvscript/dashboardChart.js                         |  117 
 /jvscript/header.js                                 |   34 
 BLL/Permissoes.php                                  |   19 
 BLL/permissoes_oldFunction.text                     |   27 
 CSS/styleDashboard.css                              |    6 
 CSS/styleGlobal.css                                 |  219 
 CSS/stylePerfil.css                                 |   64 
 DAL/login_dal.php                                   |    1 
 Dicionário                                          |    9 
 Permissoes.php                                      |    1 
 UI/criarEquipa.php                                  |    1 
 UI/dashboard.php                                    |   13 
 UI/equipas.php                                      |    2 
 UI/login.php                                        |    3 
 UI/perfil.php                                       |    3 
 UI/teste.html                                       |   57 
 b/BLL/Permissoes.php                                |    9 
 b/BLL/dashboard_bll.php                             |    6 
 b/BLL/dashboard_pag_bll.php                         |   27 
 b/BLL/perfil_bll.php                                |    4 
 b/BLL/permissoes_oldFunction.text                   |   27 
 b/CSS/styleDashboard.css                            |    2 
 b/CSS/styleEquipas.css                              |   76 
 b/CSS/styleGlobal.css                               |  151 
 b/CSS/styleLogin.css                                |   18 
 b/CSS/stylePerfil.css                               |   20 
 b/CSS/styleVisualizarFuncionario.css                |    4 
 b/DAL/dashboard_dal.php                             |    2 
 b/DAL/login_dal.php                                 |    3 
 b/DAL/profile_dal.php                               |    2 
 b/Dicionário                                        |    1 
 b/UI/atualizarPerfil.php                            |   12 
 b/UI/criarEquipa.php                                |    3 
 b/UI/dashboard.php                                  |   23 
 b/UI/equipas.php                                    |    3 
 b/UI/login.php                                      |    1 
 b/UI/perfil.php                                     |    3 
 b/UI/teste.html                                     |   57 
 b/UI/teste.php                                      |   46 
 b/UI/ttt.html                                       |   27 
 b/bll/handle_login.php                              |    1 
 b/bootstrap/css/bootstrap-grid.css                  | 4085 ++++++
 b/bootstrap/css/bootstrap-grid.css.map              |    1 
 b/bootstrap/css/bootstrap-grid.min.css              |    6 
 b/bootstrap/css/bootstrap-grid.min.css.map          |    1 
 b/bootstrap/css/bootstrap-grid.rtl.css              | 4084 ++++++
 b/bootstrap/css/bootstrap-grid.rtl.css.map          |    1 
 b/bootstrap/css/bootstrap-grid.rtl.min.css          |    6 
 b/bootstrap/css/bootstrap-grid.rtl.min.css.map      |    1 
 b/bootstrap/css/bootstrap-reboot.css                |  597 
 b/bootstrap/css/bootstrap-reboot.css.map            |    1 
 b/bootstrap/css/bootstrap-reboot.min.css            |    6 
 b/bootstrap/css/bootstrap-reboot.min.css.map        |    1 
 b/bootstrap/css/bootstrap-reboot.rtl.css            |  594 
 b/bootstrap/css/bootstrap-reboot.rtl.css.map        |    1 
 b/bootstrap/css/bootstrap-reboot.rtl.min.css        |    6 
 b/bootstrap/css/bootstrap-reboot.rtl.min.css.map    |    1 
 b/bootstrap/css/bootstrap-utilities.css             | 5406 ++++++++
 b/bootstrap/css/bootstrap-utilities.css.map         |    1 
 b/bootstrap/css/bootstrap-utilities.min.css         |    6 
 b/bootstrap/css/bootstrap-utilities.min.css.map     |    1 
 b/bootstrap/css/bootstrap-utilities.rtl.css         | 5397 ++++++++
 b/bootstrap/css/bootstrap-utilities.rtl.css.map     |    1 
 b/bootstrap/css/bootstrap-utilities.rtl.min.css     |    6 
 b/bootstrap/css/bootstrap-utilities.rtl.min.css.map |    1 
 b/bootstrap/css/bootstrap.css                       |12043 ++++++++++++++++++++
 b/bootstrap/css/bootstrap.css.map                   |    1 
 b/bootstrap/css/bootstrap.min.css                   |    6 
 b/bootstrap/css/bootstrap.min.css.map               |    1 
 b/bootstrap/css/bootstrap.rtl.css                   |12016 +++++++++++++++++++
 b/bootstrap/css/bootstrap.rtl.css.map               |    1 
 b/bootstrap/css/bootstrap.rtl.min.css               |    6 
 b/bootstrap/css/bootstrap.rtl.min.css.map           |    1 
 b/bootstrap/js/bootstrap.bundle.js                  | 6315 ++++++++++
 b/bootstrap/js/bootstrap.bundle.js.map              |    1 
 b/bootstrap/js/bootstrap.bundle.min.js              |    7 
 b/bootstrap/js/bootstrap.bundle.min.js.map          |    1 
 b/bootstrap/js/bootstrap.esm.js                     | 4450 +++++++
 b/bootstrap/js/bootstrap.esm.js.map                 |    1 
 b/bootstrap/js/bootstrap.esm.min.js                 |    7 
 b/bootstrap/js/bootstrap.esm.min.js.map             |    1 
 b/bootstrap/js/bootstrap.js                         | 4497 +++++++
 b/bootstrap/js/bootstrap.js.map                     |    1 
 b/bootstrap/js/bootstrap.min.js                     |    7 
 b/bootstrap/js/bootstrap.min.js.map                 |    1 
 b/jvscript/dashboardChart.js                        |    2 
 b/jvscript/generoChart.js                           |   77 
 b/jvscript/header.js                                |    4 
 b/photos/Pessoa_chapeu.jpg                          |binary
 bll/handle_login.php                                |    2 
 bootstrap/css/bootstrap-grid.css                    | 4085 ------
 bootstrap/css/bootstrap-grid.css.map                |    1 
 bootstrap/css/bootstrap-grid.min.css                |    6 
 bootstrap/css/bootstrap-grid.min.css.map            |    1 
 bootstrap/css/bootstrap-grid.rtl.css                | 4084 ------
 bootstrap/css/bootstrap-grid.rtl.css.map            |    1 
 bootstrap/css/bootstrap-grid.rtl.min.css            |    6 
 bootstrap/css/bootstrap-grid.rtl.min.css.map        |    1 
 bootstrap/css/bootstrap-reboot.css                  |  597 
 bootstrap/css/bootstrap-reboot.css.map              |    1 
 bootstrap/css/bootstrap-reboot.min.css              |    6 
 bootstrap/css/bootstrap-reboot.min.css.map          |    1 
 bootstrap/css/bootstrap-reboot.rtl.css              |  594 
 bootstrap/css/bootstrap-reboot.rtl.css.map          |    1 
 bootstrap/css/bootstrap-reboot.rtl.min.css          |    6 
 bootstrap/css/bootstrap-reboot.rtl.min.css.map      |    1 
 bootstrap/css/bootstrap-utilities.css               | 5406 --------
 bootstrap/css/bootstrap-utilities.css.map           |    1 
 bootstrap/css/bootstrap-utilities.min.css           |    6 
 bootstrap/css/bootstrap-utilities.min.css.map       |    1 
 bootstrap/css/bootstrap-utilities.rtl.css           | 5397 --------
 bootstrap/css/bootstrap-utilities.rtl.css.map       |    1 
 bootstrap/css/bootstrap-utilities.rtl.min.css       |    6 
 bootstrap/css/bootstrap-utilities.rtl.min.css.map   |    1 
 bootstrap/css/bootstrap.css                         |12043 --------------------
 bootstrap/css/bootstrap.css.map                     |    1 
 bootstrap/css/bootstrap.min.css                     |    6 
 bootstrap/css/bootstrap.min.css.map                 |    1 
 bootstrap/css/bootstrap.rtl.css                     |12016 -------------------
 bootstrap/css/bootstrap.rtl.css.map                 |    1 
 bootstrap/css/bootstrap.rtl.min.css                 |    6 
 bootstrap/css/bootstrap.rtl.min.css.map             |    1 
 bootstrap/js/bootstrap.bundle.js                    | 6315 ----------
 bootstrap/js/bootstrap.bundle.js.map                |    1 
 bootstrap/js/bootstrap.bundle.min.js                |    7 
 bootstrap/js/bootstrap.bundle.min.js.map            |    1 
 bootstrap/js/bootstrap.esm.js                       | 4450 -------
 bootstrap/js/bootstrap.esm.js.map                   |    1 
 bootstrap/js/bootstrap.esm.min.js                   |    7 
 bootstrap/js/bootstrap.esm.min.js.map               |    1 
 bootstrap/js/bootstrap.js                           | 4497 -------
 bootstrap/js/bootstrap.js.map                       |    1 
 bootstrap/js/bootstrap.min.js                       |    7 
 bootstrap/js/bootstrap.min.js.map                   |    1 
 jvscript/generoChart.js                             |   77 
 jvscript/header.js                                  |    7 
 142 files changed, 60507 insertions(+), 60014 deletions(-), 137 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 6087359eca6e11d88badab3c51ad24c61b2ca760	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sun Jun 29 23:02:03 2025 +0100

    sprint 2 realizada

M	"Dicion\303\241rio"

commit 965c94b9f2b3a53c0993819435de17d7baf959ba	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sun Jun 29 17:48:57 2025 +0100

    fix aspeto dashboardChart

M	CSS/styleDashboard.css
M	CSS/styleVisualizarFuncionario.css
M	jvscript/dashboardChart.js

commit f0ea28b796bc436861650dd94f7dc5d8840d4e46	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sat Jun 28 23:43:07 2025 +0100

    fix header.js

M	jvscript/header.js

commit e47e4e0ae27c2b94f16d58945e0863c417772e96	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sat Jun 28 23:38:17 2025 +0100

    cssGlobal, cssHeader, fix permissoes, criacao styleEquipas, criacao pagina Dashboard

M	BLL/Permissoes.php
M	BLL/dashboard_bll.php
A	BLL/dashboard_pag_bll.php
D	BLL/permissoes_oldFunction.text
M	CSS/styleDashboard.css
A	CSS/styleEquipas.css
M	CSS/styleGlobal.css
M	CSS/stylePerfil.css
M	DAL/dashboard_dal.php
M	UI/atualizarPerfil.php
M	UI/criarEquipa.php
M	UI/dashboard.php
M	UI/equipas.php
M	UI/login.php
M	UI/perfil.php
M	jvscript/header.js

commit 506d9b9d4b3c3e7ee8928d947b46b0f3663e9ac2	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 22:01:43 2025 +0100

    tabs funcionais, mas nao conectadas ainda á box

M	BLL/Permissoes.php
A	BLL/permissoes_oldFunction.text
M	CSS/styleGlobal.css
M	CSS/stylePerfil.css
M	UI/perfil.php
A	jvscript/header.js

commit 11c6f4b0e2b3371aa56c9a788394042d484de074	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 20:51:06 2025 +0100

    delete bootstrap local files

D	bootstrap/css/bootstrap-grid.css
D	bootstrap/css/bootstrap-grid.css.map
D	bootstrap/css/bootstrap-grid.min.css
D	bootstrap/css/bootstrap-grid.min.css.map
D	bootstrap/css/bootstrap-grid.rtl.css
D	bootstrap/css/bootstrap-grid.rtl.css.map
D	bootstrap/css/bootstrap-grid.rtl.min.css
D	bootstrap/css/bootstrap-grid.rtl.min.css.map
D	bootstrap/css/bootstrap-reboot.css
D	bootstrap/css/bootstrap-reboot.css.map
D	bootstrap/css/bootstrap-reboot.min.css
D	bootstrap/css/bootstrap-reboot.min.css.map
D	bootstrap/css/bootstrap-reboot.rtl.css
D	bootstrap/css/bootstrap-reboot.rtl.css.map
D	bootstrap/css/bootstrap-reboot.rtl.min.css
D	bootstrap/css/bootstrap-reboot.rtl.min.css.map
D	bootstrap/css/bootstrap-utilities.css
D	bootstrap/css/bootstrap-utilities.css.map
D	bootstrap/css/bootstrap-utilities.min.css
D	bootstrap/css/bootstrap-utilities.min.css.map
D	bootstrap/css/bootstrap-utilities.rtl.css
D	bootstrap/css/bootstrap-utilities.rtl.css.map
D	bootstrap/css/bootstrap-utilities.rtl.min.css
D	bootstrap/css/bootstrap-utilities.rtl.min.css.map
D	bootstrap/css/bootstrap.css
D	bootstrap/css/bootstrap.css.map
D	bootstrap/css/bootstrap.min.css
D	bootstrap/css/bootstrap.min.css.map
D	bootstrap/css/bootstrap.rtl.css
D	bootstrap/css/bootstrap.rtl.css.map
D	bootstrap/css/bootstrap.rtl.min.css
D	bootstrap/css/bootstrap.rtl.min.css.map
D	bootstrap/js/bootstrap.bundle.js
D	bootstrap/js/bootstrap.bundle.js.map
D	bootstrap/js/bootstrap.bundle.min.js
D	bootstrap/js/bootstrap.bundle.min.js.map
D	bootstrap/js/bootstrap.esm.js
D	bootstrap/js/bootstrap.esm.js.map
D	bootstrap/js/bootstrap.esm.min.js
D	bootstrap/js/bootstrap.esm.min.js.map
D	bootstrap/js/bootstrap.js
D	bootstrap/js/bootstrap.js.map
D	bootstrap/js/bootstrap.min.js
D	bootstrap/js/bootstrap.min.js.map

commit f4df344184218bc773881117bab4bcc365e6c4f6	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 20:48:10 2025 +0100

    background perfil

M	CSS/styleGlobal.css
M	CSS/stylePerfil.css

commit 14e917c332f469ee63199acd2d256bf6c4513d46	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 19:31:57 2025 +0100

    order dicionario

M	"Dicion\303\241rio"

commit 4cf363588055d4e5da1827d993b80c270f9b704b	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 19:05:20 2025 +0100

    new update on stylePerfil e styleGlobal

R097	UI/Permissoes.php	BLL/Permissoes.php
M	BLL/perfil_bll.php
M	CSS/styleGlobal.css
M	CSS/stylePerfil.css
M	"Dicion\303\241rio"
M	UI/criarEquipa.php
M	UI/equipas.php
M	UI/perfil.php
A	photos/Pessoa_chapeu.jpg

commit f5616c97893db8f60725ba2d6744dee86b41d2ec	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 12:34:48 2025 +0100

    alteraçãos no styleGlobal e stylePerfil

M	CSS/styleGlobal.css
A	CSS/stylePerfil.css
M	"Dicion\303\241rio"
M	UI/perfil.php
A	UI/ttt.html

commit 8bd6d4eb25d1eeae114a4cafbfde1b212c8a44e7	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 11:59:16 2025 +0100

    styleLogin updated

M	CSS/styleLogin.css
M	UI/login.php

commit cf1ba8ddb52dabd846c9e2bd02bf1b441dfe9828	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 10:28:34 2025 +0100

    teste bootstrap

M	UI/dashboard.php
D	UI/teste.html
A	UI/teste.php

commit 34505d87bd7714f628e6402fc3eaa68231266d02	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jun 27 10:03:35 2025 +0100

    bootstrap add

M	"Dicion\303\241rio"
A	bootstrap/css/bootstrap-grid.css
A	bootstrap/css/bootstrap-grid.css.map
A	bootstrap/css/bootstrap-grid.min.css
A	bootstrap/css/bootstrap-grid.min.css.map
A	bootstrap/css/bootstrap-grid.rtl.css
A	bootstrap/css/bootstrap-grid.rtl.css.map
A	bootstrap/css/bootstrap-grid.rtl.min.css
A	bootstrap/css/bootstrap-grid.rtl.min.css.map
A	bootstrap/css/bootstrap-reboot.css
A	bootstrap/css/bootstrap-reboot.css.map
A	bootstrap/css/bootstrap-reboot.min.css
A	bootstrap/css/bootstrap-reboot.min.css.map
A	bootstrap/css/bootstrap-reboot.rtl.css
A	bootstrap/css/bootstrap-reboot.rtl.css.map
A	bootstrap/css/bootstrap-reboot.rtl.min.css
A	bootstrap/css/bootstrap-reboot.rtl.min.css.map
A	bootstrap/css/bootstrap-utilities.css
A	bootstrap/css/bootstrap-utilities.css.map
A	bootstrap/css/bootstrap-utilities.min.css
A	bootstrap/css/bootstrap-utilities.min.css.map
A	bootstrap/css/bootstrap-utilities.rtl.css
A	bootstrap/css/bootstrap-utilities.rtl.css.map
A	bootstrap/css/bootstrap-utilities.rtl.min.css
A	bootstrap/css/bootstrap-utilities.rtl.min.css.map
A	bootstrap/css/bootstrap.css
A	bootstrap/css/bootstrap.css.map
A	bootstrap/css/bootstrap.min.css
A	bootstrap/css/bootstrap.min.css.map
A	bootstrap/css/bootstrap.rtl.css
A	bootstrap/css/bootstrap.rtl.css.map
A	bootstrap/css/bootstrap.rtl.min.css
A	bootstrap/css/bootstrap.rtl.min.css.map
A	bootstrap/js/bootstrap.bundle.js
A	bootstrap/js/bootstrap.bundle.js.map
A	bootstrap/js/bootstrap.bundle.min.js
A	bootstrap/js/bootstrap.bundle.min.js.map
A	bootstrap/js/bootstrap.esm.js
A	bootstrap/js/bootstrap.esm.js.map
A	bootstrap/js/bootstrap.esm.min.js
A	bootstrap/js/bootstrap.esm.min.js.map
A	bootstrap/js/bootstrap.js
A	bootstrap/js/bootstrap.js.map
A	bootstrap/js/bootstrap.min.js
A	bootstrap/js/bootstrap.min.js.map

commit 42347b03faa68af02ff5bcccfcffc2c9fdd996e1	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Thu Jun 26 19:02:26 2025 +0100

    filtros

M	UI/dashboard.php
A	jvscript/dashboardChart.js
D	jvscript/generoChart.js

commit d88b76bf5daaa347c3b5fedc29b24bfc6cdeaba5	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Thu Jun 26 18:04:03 2025 +0100

    3 graficos funcionais

A	BLL/dashboard_bll.php
A	CSS/styleDashboard.css
A	DAL/dashboard_dal.php
A	UI/dashboard.php
A	UI/teste.html
A	jvscript/generoChart.js

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
 /BLL/equipaBLL.php           |   23 ++++++
 /DAL/equipaDal.php           |   20 +++++
 BLL/equipaBLL.php            |   12 ++-
 BLL/handle_login.php         |    3 
 DAL/connection.php           |   12 -
 DAL/equipaDal.php            |  146 ++++++++++++++++++++++++++-!!!!!!!!!!!!!
 DAL/login_dal.php            |   44 ++++++!!!!!!
 UI/Equipas.html              |    2 
 UI/Permissoes.php            |    2 
 UI/equipas.php               |  147 ++++!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 UI/login.php                 |    2 
 UI/perfil.php                |    1 
 b/BLL/dashboard_bll.php      |    7 ++
 b/BLL/equipaBLL.php          |   15 --!
 b/BLL/handle_login.php       |    3 
 b/DAL/connection.php         |    1 
 b/DAL/dashboard_dal.php      |    2 
 b/DAL/equipaDal.php          |   10 !!
 b/DAL/login_dal.php          |    1 
 b/UI/Equipas.html            |    1 
 b/UI/Permissoes.php          |    2 
 b/UI/atualizarPerfil.html    |    1 
 b/UI/dashboard.php           |    2 
 b/UI/equipas.php             |   66 !!!!!!!!!!!!!!!!!!
 b/UI/guest.html              |    1 
 b/UI/login.php               |    3 
 b/UI/perfil.php              |   10 -
 b/jvscript/dashboardChart.js |    4 !
 28 files changed, 205 insertions(+), 16 deletions(-), 322 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 209102e1c597bf46e472602bb1ec9952410ca9c6	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Fri Jun 27 20:08:36 2025 +0100

    perfil changes para idcargo

M	UI/Permissoes.php

commit 497f378c1919a225620c44e979be4770806c5ed5	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Fri Jun 27 16:28:29 2025 +0100

    vista de equipa do coordenador

M	DAL/equipaDal.php

commit 1edd86fd34f20c29ca8521483099cd145c60e46e	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Fri Jun 27 10:48:03 2025 +0100

    .

M	BLL/dashboard_bll.php
M	DAL/dashboard_dal.php
M	UI/dashboard.php
M	jvscript/dashboardChart.js

commit 6c265052dfb3f9311b955d573000d5dd842472e1	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Thu Jun 26 17:57:20 2025 +0100

    127.0.0.1 em vez de localhost

M	DAL/connection.php

commit 881b00d11e507d1bec4f8e4f7b2ca95040074544	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Thu Jun 26 17:28:18 2025 +0100

    equipa changes

M	BLL/equipaBLL.php
M	DAL/equipaDal.php
M	DAL/login_dal.php
M	UI/equipas.php

commit 03a9f4ac5abb716a71acd667f75e78678d9a6078	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Thu Jun 26 15:54:02 2025 +0100

    login and equipas changes

M	BLL/handle_login.php
M	DAL/equipaDal.php
M	DAL/login_dal.php
M	UI/Permissoes.php
M	UI/equipas.php

commit 21ecc8f4869f5888771750d7e6b0eac64a7c283b	refs/heads/main
Author: Jose Pereira <1230650@isep.ipp.pt>
Date:   Wed Jun 25 22:05:55 2025 +0100

    mudanças código equipas

M	BLL/equipaBLL.php
M	BLL/handle_login.php
M	DAL/equipaDal.php
M	UI/Permissoes.php
M	UI/equipas.php
M	UI/perfil.php

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
 /BLL/criarEquipa_bll.php       |   23 +
 /DAL/criarEquipa_dal.php       |   60 ++++
 /DAL/perfil_dal.php            |   21 +
 /UI/Permissoes.php             |   45 +++
 /UI/atualizarPerfil.php        |   18 +
 /UI/criarEquipa.php            |   26 ++
 /UI/profile.php                |   75 +++++
 /profile_dal.php               |    2 
 BLL/atualizarPerfil_bll.php    |  519 +++++++++++++++++++++++++------!!!!!!!!
 BLL/criarEquipa_bll.php        |  128 +++++--!
 BLL/perfil_bll.php             |    2 
 CSS/styleAtualizarPerfil.css   |    1 
 CSS/styleGlobal.css            |   58 ++++
 DAL/atualizarPerfil_dal.php    |  206 ++++++++++++++++
 DAL/criarEquipa_dal.php        |  139 ++++++-!!!
 DAL/perfil_dal.php             |   54 +++
 DAL/profile_dal.php            |   23 -
 UI/Permissoes.php              |   20 !
 UI/atualizarPerfil.html        |   87 ------
 UI/atualizarPerfil.php         |    7 
 UI/criarEquipa.php             |    5 
 UI/perfil.php                  |  117 +-------
 UI/profile.html                |   65 -----
 b/BLL/Permissoes.php           |    1 
 b/BLL/atualizarPerfil_bll.php  |   37 ++
 b/BLL/criarEquipa_bll.php      |    2 
 b/BLL/login_bll.php            |   22 +
 b/BLL/perfil_bll.php           |    1 
 b/CSS/styleAtualizarPerfil.css |   97 +++++++
 b/CSS/styleGlobal.css          |    6 
 b/DAL/atualizarPerfil_dal.php  |   14 !
 b/DAL/connection.php           |    1 
 b/DAL/criarEquipa_dal.php      |   30 --
 b/DAL/login_dal.php            |    1 
 b/DAL/perfil_dal.php           |    1 
 b/DAL/profile_dal.php          |   22 +
 b/UI/Equipas.html              |    2 
 b/UI/Permissoes.php            |    1 
 b/UI/atualizarPerfil.php       |    2 
 b/UI/criarEquipa.php           |    1 
 b/UI/login.php                 |   17 -
 b/UI/logout.php                |   22 +
 b/UI/perfil.php                |   21 -
 b/UI/profile.php               |   12 
 b/UI/updateProfile.html        |    1 
 b/bll/handle_login.php         |    1 
 b/bll/perfil_bll.php           |    2 
 b/bll/profile_bll.php          |   19 +
 bll/perfil_bll.php             |   91 ++++!!!
 49 files changed, 1359 insertions(+), 440 deletions(-), 329 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 92d76d90b47c17ff8fedb846ed24ed9f77610a31	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sun Jun 29 14:29:45 2025 +0100

    criarEquipa

M	BLL/criarEquipa_bll.php

commit 98efdb8daf4349717add6ff7bac3f8645915917d	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jun 28 15:41:34 2025 +0100

    styles criar equioa atualizar perfil

M	BLL/atualizarPerfil_bll.php
M	CSS/styleAtualizarPerfil.css
M	CSS/styleGlobal.css
M	UI/atualizarPerfil.php

commit 0c9de50bffb186a2942a36b5f106dca6761789bf	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jun 28 13:47:42 2025 +0100

    style Criar  equipa

M	BLL/criarEquipa_bll.php
M	CSS/styleGlobal.css
M	UI/criarEquipa.php

commit d00d40b19b008736d8a194ab3f4c41dfe46d9d99	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jun 27 19:16:34 2025 +0100

    header fix

M	BLL/Permissoes.php
M	BLL/perfil_bll.php

commit a6f23e3ef7c98c0edcba7a7fdbd920ad20110b94	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jun 27 11:40:58 2025 +0100

    criar equipa bug fixed

M	BLL/criarEquipa_bll.php
M	DAL/criarEquipa_dal.php

commit aee44661ca2267341ba72ae1b45afbcfe749ae82	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jun 27 10:34:27 2025 +0100

    login bll

R066	BLL/handle_login.php	BLL/login_bll.php
M	UI/login.php

commit ed06e6f92952916eadd7a06f08929b7935ae234b	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jun 27 10:12:43 2025 +0100

    teste

M	CSS/styleAtualizarPerfil.css

commit 2a3c0bb4ab8790d2a163f1d12d0aa708ba639ae1	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jun 27 10:01:27 2025 +0100

    atualizarPerfil ja atualiza

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit 46f7213f185bd03b076baf742c1d8a994e1a90e9	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jun 27 09:10:15 2025 +0100

    atualizar perfil

M	BLL/atualizarPerfil_bll.php

commit 28e4dde31437d9c4f3e5033b04a7e440d59346ea	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 18:47:08 2025 +0100

    aaaaa vou descansar pausa no atualizar perfil

M	BLL/atualizarPerfil_bll.php

commit beb9f94533bad792ec4de13647286f9206757c1e	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 18:38:05 2025 +0100

    atualizar perfil vou testar

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php
M	UI/atualizarPerfil.php

commit 1447f45c101f4149b86afc2f28539fc4c28660c2	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 18:06:47 2025 +0100

    aaaaa

M	BLL/atualizarPerfil_bll.php

commit 7eadfe66fdd33d542f973bf41ae238e46fa9ed9a	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 17:19:37 2025 +0100

    atualizarPerfil ja mostra os dados antigos

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit 997d277f4df3a5b3028a7beda542cbe011b810a5	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 16:24:00 2025 +0100

    atualizar perfil dados pessoais

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php
M	UI/atualizarPerfil.php

commit ae4382f7e4d865fd371cc09165a6e70427547c6a	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 14:32:09 2025 +0100

    minor atualizar perfil

M	BLL/atualizarPerfil_bll.php

commit d6b26f93a5d1b8a5d2916ebdab8369cf8da5fd23	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 14:19:51 2025 +0100

    atualizar perfil em pausa

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit 8d7fafead9af769ad38d85cef5c4d4b15d294524	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 13:00:53 2025 +0100

    hora de almoço

M	UI/atualizarPerfil.php

commit 9c1209eb27aff46508e17d25382f7fa8841b3e14	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 12:58:25 2025 +0100

    fix perfil

M	BLL/perfil_bll.php
M	UI/perfil.php

commit aa426e17399021e292a74fca3f679cc6984f508c	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 12:56:27 2025 +0100

    atualizar perfil

M	BLL/atualizarPerfil_bll.php
A	DAL/atualizarPerfil_dal.php
D	UI/atualizarPerfil.html
A	UI/atualizarPerfil.php

commit 37232a3fe7896b62cdefb2699fd4f2648b3bec82	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 11:53:33 2025 +0100

    fix criar equipa

M	BLL/criarEquipa_bll.php

commit 1e88d9ce64b94066f75d025417e7cd19bb3b8d58	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jun 26 11:44:54 2025 +0100

    criarEquipa

M	BLL/criarEquipa_bll.php
M	DAL/criarEquipa_dal.php
M	UI/criarEquipa.php

commit b4d426584b2d6bda85fa1576002984aa9ecd2ef8	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 23:25:53 2025 +0100

    criarEquipa

M	BLL/criarEquipa_bll.php
M	DAL/criarEquipa_dal.php

commit a051e8fe1a8a57c9deb3021a804466b0eb856799	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 21:58:55 2025 +0100

    fix

M	BLL/perfil_bll.php
M	UI/Permissoes.php
M	UI/perfil.php

commit 09002af27804311e294830ac901c80afc18bd88f	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 21:54:38 2025 +0100

    permissoes

M	UI/Permissoes.php

commit fa3338ad740543cb7c9cc76309ea989c47e4846e	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jun 25 21:39:44 2025 +0100

    con

M	DAL/connection.php

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
 /CSS/styleAtualizarPerfil.css         |    3 
 /DAL/registoFuncionario_dal.php       |  113 ++++++++++++++++++++++++++++
 /UI/admin/registoFuncionario.html     |  133 ++++++++++++++++++++++++++++++++++
 /UI/admin/registoFuncionario.php      |   18 ++++
 BLL/atualizarPerfil_bll.php           |    2 
 BLL/perfil_bll.php                    |    1 
 BLL/registoFuncionario_bll.php        |  105 +++++++++-----!!!!!!!!!!
 DAL/connection.php                    |    2 
 DAL/login_dal.php                     |    1 
 DAL/perfil_dal.php                    |   12 !!
 DAL/registoFuncionario_dal.php        |  127 +++++++++++++++!!!!!!!!!!!!!!!!
 b/BLL/atualizarPerfil_bll.php         |    2 
 b/BLL/criarEquipa_bll.php             |    2 
 b/BLL/perfil_bll.php                  |    1 
 b/BLL/registoFuncionario_bll.php      |   96 ++++++++++++++++++--!!!
 b/BLL/visualizarFuncionario_bll.php   |   41 ++++++++++
 b/CSS/styleAtualizarPerfil.css        |    2 
 b/CSS/styleLogin.css                  |    2 
 b/CSS/styleVisualizarFuncionario.css  |   54 +++++++++++++
 b/DAL/connection.php                  |    1 
 b/DAL/login_dal.php                   |    1 
 b/DAL/perfil_dal.php                  |    1 
 b/DAL/registoFuncionario_dal.php      |    7 +
 b/DAL/visualizarFuncionario_dal.php   |   47 ++++++++++++
 b/UI/admin/admin.html                 |   11 ++
 b/UI/admin/admin.php                  |    2 
 b/UI/admin/registoFuncionario.html    |   48 +++++++++!!!
 b/UI/admin/registoFuncionario.php     |    1 
 b/UI/admin/visualizarFuncionarios.php |   17 ++++
 b/UI/atualizarPerfil.html             |    1 
 b/UI/login.php                        |    1 
 b/UI/perfil.php                       |    7 -
 32 files changed, 659 insertions(+), 39 deletions(-), 164 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 8c699b7818b42ebd46e40a4b04c9dc5cc3149a73	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Fri Jun 27 10:13:42 2025 +0100

    teste
    
    teste

M	CSS/styleAtualizarPerfil.css

commit 14c47381880ccf87422ba559f1f0fed030c8b456	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Fri Jun 27 09:11:28 2025 +0100

    Update atualizarPerfil_bll.php
    
    teste

M	BLL/atualizarPerfil_bll.php

commit d2e9beeb4253d64d93810576a66252eb4e9117df	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Fri Jun 27 09:10:55 2025 +0100

    Update atualizarPerfil_bll.php

M	BLL/atualizarPerfil_bll.php

commit 8ed6b1e6a4da39d886bec1155c1d023f4065e060	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Thu Jun 26 17:28:42 2025 +0100

    visualizarFuncionarios
    
    Visualizar funcionarios está concluida parte funcional, falta melhorar css

A	BLL/visualizarFuncionario_bll.php
A	CSS/styleVisualizarFuncionario.css
M	DAL/connection.php
A	DAL/visualizarFuncionario_dal.php
M	UI/admin/admin.php
M	UI/admin/visualizarFuncionarios.php

commit f75e67ae00503d28add199f7733598b4a0ec4f7f	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Thu Jun 26 01:39:30 2025 +0100

    inicio visualizarFuncionario
    
    inicio visualizarFuncionario

M	BLL/criarEquipa_bll.php
A	UI/admin/visualizarFuncionarios.php
M	UI/perfil.php

commit a13a596fb0e121582dbd1184bd45770b11486c4e	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jun 25 23:44:27 2025 +0100

    registoFuncionario concluida
    
    O registo funcionário está concluido

M	BLL/registoFuncionario_bll.php
M	DAL/registoFuncionario_dal.php

commit 48f8d98346f8e243713f9c5853f02edc83644080	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jun 25 20:55:40 2025 +0100

    update registarFuncionario
    
    Ja insere os dados login, pessoais, financeiros, cv, viatura, beneficios, contrato,... Apenas falta adicionar as ligações das tabelas com FK

M	BLL/registoFuncionario_bll.php
M	DAL/registoFuncionario_dal.php

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


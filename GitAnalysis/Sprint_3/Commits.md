# Commits by author
#### 1220893@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /BLL/export_importData_bll.php        |   18 
 /DAL/export_importData_dal.php        |  202 +++++
 BLL/Permissoes.php                    |    1 
 BLL/dashboard_bll.php                 |  172 +-!
 BLL/dashboard_pag_bll.php             |   71 +!
 BLL/exportData_bll.php                |    9 
 BLL/visualizarFuncionario_bll.php     |   14 
 CSS/styleDashboard.css                |   98 +!
 DAL/dashboard_dal.php                 | 1167 +++++++++++++++++--------!!!!!!!!
 DAL/exportData_dal.php                |   58 -
 b/BLL/Permissoes.php                  |    3 
 b/BLL/alertas_bll.php                 |   15 
 b/BLL/dashboard_bll.php               |    6 
 b/BLL/dashboard_pag_bll.php           |    3 
 b/BLL/exportData_bll.php              |    9 
 b/BLL/export_importData_bll.php       |    8 
 b/BLL/login_bll.php                   |    2 
 b/BLL/registoFuncionario_bll.php      |    2 
 b/BLL/visualizarFuncionario_bll.php   |   12 
 b/CSS/styleDashboard.css              |    6 
 b/CSS/styleGlobal.css                 |    3 
 b/CSS/styleVisualizarFuncionario.css  |    4 
 b/DAL/alertas_dal.php                 |   28 
 b/DAL/dashboard_dal.php               |   14 
 b/DAL/exportData_dal.php              |   58 +
 b/DAL/export_importData_dal.php       |  108 ++!
 b/DAL/login_dal.php                   |   40 !
 b/UI/admin/visualizarFuncionarios.php |    1 
 b/UI/dashboard.php                    |    4 
 b/jvscript/dashboardChart.js          |  146 +++
 jvscript/dashboardChart.js            |  638 +++++++++++++-!!!!
 jvscript/header.js                    |   32 
 32 files changed, 1820 insertions(+), 468 deletions(-), 664 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit e803f10bd8c44fefb931a28c541a2827a265ae14	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sat Jul 5 22:12:44 2025 +0100

    delete do antigo header js das tabs

D	jvscript/header.js

commit e547b25317635c1733ca699d787cdddd797e9b80	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sat Jul 5 19:52:31 2025 +0100

    delete export js

D	jvscript/export.js

commit 11778895dd2969b70f1f89c798d3aa5a3ff84d37	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sat Jul 5 19:39:06 2025 +0100

    export das informacoes das pessoas por equipa

M	BLL/export_importData_bll.php
M	BLL/visualizarFuncionario_bll.php
M	DAL/export_importData_dal.php
A	jvscript/export.js

commit 98d65cb1c5a4302febb832bde0b308f1b7ab3595	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sat Jul 5 16:39:01 2025 +0100

    mudanca dos graficos da taxa, agora é tempo medio na tlantic e taxa de retencao

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	CSS/styleDashboard.css
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js

commit 5277f24a6350a08e81edc3418b390dc0a69a1882	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Sat Jul 5 13:31:38 2025 +0100

    grafico de barras geografia

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	CSS/styleDashboard.css
M	jvscript/dashboardChart.js

commit d9a71a3c19b0719c722bc4f52c8f28b10c6cbaa5	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jul 4 20:54:32 2025 +0100

    dal bll da taxa de retencao e de geografia

M	BLL/dashboard_bll.php
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js

commit 683bfd789e89f77c49ac65dbf1a3c68b701480f3	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jul 4 19:32:10 2025 +0100

    voltar atras no codigo, nao ha diferenca das equipas na dashboard, coordenador ve a informacao conjuta das suas equipas

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	DAL/dashboard_dal.php

commit 8ca520e71c9cc8d16dbada308ebf1cdc28ad5ca9	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jul 4 18:15:21 2025 +0100

    mostra informacao de ambas as equipas, caso coordenador tenha mais que 1

M	BLL/dashboard_bll.php
M	BLL/login_bll.php
M	DAL/dashboard_dal.php
M	DAL/login_dal.php

commit 5a6f3bfd9f5a4ce7e7bb076ac20f0b191836e157	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jul 4 17:28:01 2025 +0100

    colecta o id da Equipa

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	DAL/dashboard_dal.php

commit 7b6f87a5c3d837fe29902ca750cc811f65c91270	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jul 4 12:27:34 2025 +0100

    inicio alerta

M	BLL/Permissoes.php
A	BLL/alertas_bll.php
A	DAL/alertas_dal.php
A	UI/alertas.php

commit 6f125b8f406445c03fe8087db98649f5edddf00f	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Fri Jul 4 11:07:06 2025 +0100

    fix na visualizacao da dashboard para coordenadores sem equipa

M	BLL/dashboard_bll.php
M	DAL/dashboard_dal.php

commit 3c8ec61bb4aebc29aedd6116a2ac8127fcdaeb08	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Thu Jul 3 19:21:57 2025 +0100

    mini fix body

M	CSS/styleGlobal.css

commit 98fd2b9b7ad96b7a3eb4e21734b7229b6c3e75f1	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Thu Jul 3 17:50:58 2025 +0100

    import funciona

D	BLL/exportData_bll.php
A	BLL/export_importData_bll.php
M	BLL/visualizarFuncionario_bll.php
D	DAL/exportData_dal.php
A	DAL/export_importData_dal.php

commit 4fcc7298be2a686d7605a8b5b56337590daf27df	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Thu Jul 3 14:28:06 2025 +0100

    export data toda Excel

A	BLL/exportData_bll.php
M	BLL/visualizarFuncionario_bll.php
M	CSS/styleVisualizarFuncionario.css
A	DAL/exportData_dal.php
M	UI/admin/visualizarFuncionarios.php

commit 4317fa23c1ed4c77f9d53d03d06ef9fb87f2ee2a	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Thu Jul 3 12:11:13 2025 +0100

    filtragem de visao para coordenador, rh e rhsuper

M	BLL/Permissoes.php
M	BLL/dashboard_bll.php
M	DAL/dashboard_dal.php

commit dacd8ff32d9a5bf9a8cb957cd2348248a04f87ac	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Thu Jul 3 10:51:26 2025 +0100

    filtragem da visao da dashboard de rh para rh super

M	BLL/dashboard_bll.php
M	DAL/dashboard_dal.php
M	UI/dashboard.php

commit 03b2695ed40705276c9242185160cc0054c3141a	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Wed Jul 2 17:53:05 2025 +0100

    grafico de remuneracao, mas esta com barras em vez de linear

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	CSS/styleDashboard.css
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js

commit be76d6e871ec831d3fe07bbd27bf24943cc9c060	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Wed Jul 2 12:24:31 2025 +0100

    coomentario

M	jvscript/dashboardChart.js

commit 277c9e111fccd8d32a73d7892f44162443b9d2a2	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Wed Jul 2 12:23:08 2025 +0100

    inicio do grafico da remuneracao

M	BLL/dashboard_bll.php
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js

commit 42123397d13ea362b14069dcd1587bcbdfd4efd9	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Wed Jul 2 11:42:58 2025 +0100

    tempo inicio na tlantic media

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	CSS/styleDashboard.css
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js

commit c271983d32c5034813015dc297a7c1e724e5c862	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Tue Jul 1 19:27:20 2025 +0100

    bll/dal da data de inicio e fix da grafico da idade

M	BLL/dashboard_bll.php
M	CSS/styleDashboard.css
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js

commit ceeb4391911a6352085f6548df397eca1a3d3d4f	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Tue Jul 1 17:10:52 2025 +0100

    grafico de comparacao a idade media e a quantia de pessoas que nasceram em cada ano

M	BLL/dashboard_pag_bll.php
M	CSS/styleDashboard.css
M	jvscript/dashboardChart.js

commit a831c1b3d44b617677f83a8daf45cc7c03cde7ed	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Tue Jul 1 16:24:51 2025 +0100

    Idade média calculada

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	CSS/styleDashboard.css
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js

commit 3abee1249d4370f92ec0a16f01ca0ed47288c393	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Mon Jun 30 19:54:56 2025 +0100

    dal da idade funciona, mas grafico nao esta a ser processado

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js

commit d7c10ede55962da3474cb88c5581a25c884dc765	refs/heads/main
Author: Clara Carvalho <1220893@isep.ipp.pt>
Date:   Mon Jun 30 17:38:31 2025 +0100

    comeco do chart de idadeMedia

M	BLL/dashboard_bll.php
M	BLL/dashboard_pag_bll.php
M	BLL/registoFuncionario_bll.php
M	CSS/styleDashboard.css
M	DAL/dashboard_dal.php
M	jvscript/dashboardChart.js
</pre>

</details>

#### 1230650@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 CSS/styleEquipas.css                |  246 +++++++++++++++++++++++++++!!!!!!!!!
 UI/dashboard.php                    |    1 
 UI/equipas.php                      |  117 ++++-!!!!!!!!!!
 b/BLL/visualizarFuncionario_bll.php |    1 
 b/CSS/styleEquipas.css              |    3 
 b/DAL/equipaDal.php                 |   12 +
 b/DAL/perfil_dal.php                |    1 
 b/UI/criarEquipa.php                |    1 
 b/UI/dashboard.php                  |    1 
 b/UI/equipas.php                    |    8 !
 b/UI/perfil.php                     |    2 
 b/jvscript/equipas.js               |   10 +
 b/photos/background.png             |binary
 b/photos/logo-tlantic-header.svg    |    1 
 14 files changed, 241 insertions(+), 5 deletions(-), 158 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit beeff1fd95a1401302e822b6a64652d5acbf02a8	refs/heads/main
Author: José Miguel <1230650@isep.ipp.pt>
Date:   Fri Jul 4 18:34:21 2025 +0100

    .

M	BLL/visualizarFuncionario_bll.php
M	CSS/styleEquipas.css
M	UI/equipas.php

commit 55f92158c7e75f77873afc0d204345a3ea324f41	refs/heads/main
Author: José Miguel <1230650@isep.ipp.pt>
Date:   Thu Jul 3 16:02:43 2025 +0100

    changes to equipas

M	CSS/styleEquipas.css
M	UI/equipas.php

commit 0c7e2689ef61a65ba9be35bffd1d33bfae24f5ff	refs/heads/main
Author: José Miguel <1230650@isep.ipp.pt>
Date:   Wed Jul 2 16:36:11 2025 +0100

    minor changes

M	UI/criarEquipa.php
M	UI/dashboard.php
M	UI/equipas.php

commit a13eb5763352f1748d87f9393cddee9a9215b2ef	refs/heads/main
Author: José Miguel <1230650@isep.ipp.pt>
Date:   Wed Jul 2 16:13:34 2025 +0100

    big css changes to equipas

M	CSS/styleEquipas.css
M	UI/dashboard.php
M	UI/equipas.php
A	jvscript/equipas.js
A	photos/background.png
A	photos/logo-tlantic-header.svg

commit 4e31831ce3b0f7aacf8b428faa6b325dcfeba397	refs/heads/main
Author: José Miguel <1230650@isep.ipp.pt>
Date:   Wed Jul 2 11:54:13 2025 +0100

    Fixed nao aparecer coordenadores na vista rhsuper em equipas.php

M	DAL/equipaDal.php
M	DAL/perfil_dal.php
M	UI/perfil.php
</pre>

</details>

#### 1230794@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /BLL/editarEquipa_bll.php                                                           |   92 +
 /BLL/pedidosPendentes_bll.php                                                       |  102 +
 /DAL/editarEquipa_dal.php                                                           |  132 +
 /DAL/pedidosPendentes_dal.php                                                       |   73 
 /UI/editarEquipa.php                                                                |   24 
 BLL/Permissoes.php                                                                  |   28 
 BLL/atualizarPerfil_bll.php                                                         |  920 +++++++-!
 BLL/criarEquipa_bll.php                                                             |    3 
 BLL/editarEquipa_bll.php                                                            |    3 
 BLL/pedidosPendentes_bll.php                                                        |  213 +
 BLL/perfil_bll.php                                                                  |   32 
 BLL/registoFuncionario_bll.php                                                      |    3 
 BLL/visualizarFuncionario_bll.php                                                   |    5 
 CSS/styleAtualizarPerfil.css                                                        |    3 
 CSS/styleGlobal.css                                                                 |   62 
 CSS/styleLogin.css                                                                  |    4 
 CSS/stylePerfil.css                                                                 |   11 
 DAL/atualizarPerfil_dal.php                                                         |  240 +
 DAL/pedidosPendentes_dal.php                                                        |   24 
 DAL/perfil_dal.php                                                                  |   10 
 DAL/visualizarFuncionario_dal.php                                                   |    5 
 UI/criarEquipa.php                                                                  |    5 
 UI/editarEquipa.php                                                                 |    8 
 UI/equipas.php                                                                      |   35 
 UI/perfil.php                                                                       |   28 
 UI/teste.php                                                                        |   46 
 UI/ttt.html                                                                         |   27 
 b/BLL/Permissoes.php                                                                |    3 
 b/BLL/atualizarPerfil_bll.php                                                       |   27 
 b/BLL/criarEquipa_bll.php                                                           |    2 
 b/BLL/editarEquipa_bll.php                                                          |   12 
 b/BLL/pedidosPendentes_bll.php                                                      |   22 
 b/BLL/perfil_bll.php                                                                |    1 
 b/BLL/registoFuncionario_bll.php                                                    |    1 
 b/BLL/visualizarFuncionario_bll.php                                                 |   30 
 b/CSS/styleAtualizarPerfil.css                                                      |   53 
 b/CSS/styleGlobal.css                                                               |   20 
 b/CSS/styleLogin.css                                                                |    2 
 b/CSS/stylePedidoPendentes.css                                                      |   82 
 b/CSS/stylePerfil.css                                                               |   10 
 b/DAL/atualizarPerfil_dal.php                                                       |    3 
 b/DAL/editarEquipa_dal.php                                                          |    5 
 b/DAL/pedidosPendentes_dal.php                                                      |  524 +++++
 b/DAL/perfil_dal.php                                                                |    8 
 b/DAL/registoFuncionario_dal.php                                                    |    1 
 b/DAL/visualizarFuncionario_dal.php                                                 |   35 
 b/UI/admin/visualizarFuncionarios.php                                               |    6 
 b/UI/atualizarPerfil.php                                                            |    6 
 b/UI/criarEquipa.php                                                                |    1 
 b/UI/editarEquipa.php                                                               |    1 
 b/UI/equipas.php                                                                    |    3 
 b/UI/login.php                                                                      |    9 
 b/UI/pedidosPendentes.php                                                           |   24 
 b/UI/perfil.php                                                                     |    1 
 b/documentos/CartaoCidadao/6866f3d5d5ddd_5.4_-_PHP_(Good_Practices).pdf             |binary
 b/documentos/CartaoCidadao/6866f3ef07fc7_summary_exam.pdf                           |   99 +
 b/documentos/CartaoCidadao/68685b97217a7_summary_exam.pdf                           |   99 +
 b/documentos/CartaoCidadao/686912bb347be_S1_GRUPO4pdf_(2).pdf                       |binary
 b/documentos/CartaoCidadao/documentoCC_68678dfc331b88.38300168.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_68678f1d7e1108.77454287.pdf                  |binary
 b/documentos/CartaoContinente/6866f3d5d6721_5.4_-_PHP_(Good_Practices).pdf          |binary
 b/documentos/CartaoContinente/6866f3ef087a2_summary_exam.pdf                        |   99 +
 b/documentos/CartaoContinente/documentoCartaoContinente_68678dfc33f050.53970343.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_68678f1d7eb062.38211410.pdf |binary
 b/documentos/DocumentoBancario/6866f3d5d644c_5.4_-_PHP_(Good_Practices).pdf         |binary
 b/documentos/DocumentoBancario/6866f3ef0854c_summary_exam.pdf                       |   99 +
 b/documentos/DocumentoBancario/documentoBancario_68678dfc33a1e7.31179465.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_68678f1d7e8057.26428800.pdf        |binary
 b/documentos/Mod99/6866f3d5d6184_5.4_-_PHP_(Good_Practices).pdf                     |binary
 b/documentos/Mod99/6866f3ef082cc_summary_exam.pdf                                   |   99 +
 b/documentos/Mod99/686912bb34ac2_summary_exam.pdf                                   |   99 +
 b/documentos/Mod99/68691334796f7_summary_exam.pdf                                   |   99 +
 b/documentos/Mod99/documentoMod99_68678dfc335d81.26002169.pdf                       |binary
 b/documentos/Mod99/documentoMod99_68678f1d7e4d54.73222333.pdf                       |binary
 74 files changed, 2983 insertions(+), 263 deletions(-), 477 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 90c659e33bbde3a5390b96c7a920c7042e8209dd	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jul 5 17:24:36 2025 +0100

    pedidopendente done

M	BLL/pedidosPendentes_bll.php

commit 5ecaf04d04653d3b4947b10bc5aea740a9301cd5	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jul 5 17:12:16 2025 +0100

    somehow its not working

M	BLL/pedidosPendentes_bll.php
M	DAL/pedidosPendentes_dal.php

commit 92cba6bf3c2d0a738ac587474e45181f1e72c97f	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jul 5 16:07:15 2025 +0100

    pedidoPendente

M	BLL/pedidosPendentes_bll.php
M	DAL/pedidosPendentes_dal.php

commit db1dbc200e80f7ff277b63e110866e80f97806bb	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jul 5 14:40:42 2025 +0100

    aceitar ou rejeitra pedidos

M	BLL/pedidosPendentes_bll.php
M	DAL/pedidosPendentes_dal.php

commit eea0cefe7c3350a04fad0c9e6648aefdf49174e3	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jul 5 12:58:32 2025 +0100

    atualizar perfil done i think

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php
A	documentos/CartaoCidadao/686912bb347be_S1_GRUPO4pdf_(2).pdf
A	documentos/Mod99/686912bb34ac2_summary_exam.pdf
A	documentos/Mod99/68691334796f7_summary_exam.pdf

commit d2de34eecc3571d0d5daa321d6b0fb3a2c44cd1d	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jul 5 12:31:00 2025 +0100

    sidebar

M	UI/equipas.php

commit e736e11487b060346196641dca7b4d31a00ea7b5	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jul 5 12:29:33 2025 +0100

    pedidosPendentes pausa para fazer fix no atualizarPerfil

M	BLL/Permissoes.php
A	BLL/pedidosPendentes_bll.php
A	CSS/stylePedidoPendentes.css
A	DAL/pedidosPendentes_dal.php
A	UI/pedidosPendentes.php

commit 8db856fd339da5b6ad9a3dabd6ba0b010edc13aa	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Sat Jul 5 09:37:14 2025 +0100

    mini changes

M	BLL/Permissoes.php
M	UI/equipas.php
M	UI/perfil.php

commit 0b26dc9319797037d26d874f46e7ee616e7ec1f7	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 23:57:16 2025 +0100

    done for today probably

M	BLL/atualizarPerfil_bll.php

commit 609b6b9e7a1dc01a558fdd0f5fac12f4bfbc73bc	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 23:55:31 2025 +0100

    atualizarPerfil ja manda o pedido

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php
A	documentos/CartaoCidadao/68685b97217a7_summary_exam.pdf

commit 07409615e7e377b396e17a3ca835a089da33c940	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 19:31:09 2025 +0100

    atualizarPerfil

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit f2e964a6c705275873ae99147e098f1f15cd1904	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 18:14:42 2025 +0100

    pausa

M	BLL/atualizarPerfil_bll.php
M	BLL/perfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit a353f8ba9b71f710e3b6dcad532c3dd88f6e1afa	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 09:54:00 2025 +0100

    rh normal so ve colaboradores

M	BLL/Permissoes.php
M	BLL/visualizarFuncionario_bll.php
M	DAL/visualizarFuncionario_dal.php
M	UI/equipas.php

commit 8cde387e3982a486928b0c8b0895eda860dd86ab	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 09:38:02 2025 +0100

    mini changes on sidebar

M	BLL/Permissoes.php
M	UI/equipas.php

commit feabd1bd05785a5da9a2c8107564460193c46b1b	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 09:37:02 2025 +0100

    equipas mini change

M	UI/equipas.php

commit 8d2baa4b5f58caf3cc2b46a8125251d2345dfc7a	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 09:25:37 2025 +0100

    registofuncionario

M	DAL/registoFuncionario_dal.php
A	documentos/CartaoCidadao/documentoCC_68678f1d7e1108.77454287.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_68678f1d7eb062.38211410.pdf
A	documentos/DocumentoBancario/documentoBancario_68678f1d7e8057.26428800.pdf
A	documentos/Mod99/documentoMod99_68678f1d7e4d54.73222333.pdf

commit 298b7a1048f982188143d782c4cdba8272fb5464	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Fri Jul 4 09:18:06 2025 +0100

    documentos

A	documentos/CartaoCidadao/documentoCC_68678dfc331b88.38300168.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_68678dfc33f050.53970343.pdf
A	documentos/DocumentoBancario/documentoBancario_68678dfc33a1e7.31179465.pdf
A	documentos/Mod99/documentoMod99_68678dfc335d81.26002169.pdf

commit f08df99e27c3db587be1c114ef01887e163eeb7e	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 22:19:59 2025 +0100

    atualizar perfil done

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php
A	documentos/CartaoCidadao/6866f3d5d5ddd_5.4_-_PHP_(Good_Practices).pdf
A	documentos/CartaoCidadao/6866f3ef07fc7_summary_exam.pdf
A	documentos/CartaoContinente/6866f3d5d6721_5.4_-_PHP_(Good_Practices).pdf
A	documentos/CartaoContinente/6866f3ef087a2_summary_exam.pdf
A	documentos/DocumentoBancario/6866f3d5d644c_5.4_-_PHP_(Good_Practices).pdf
A	documentos/DocumentoBancario/6866f3ef0854c_summary_exam.pdf
A	documentos/Mod99/6866f3d5d6184_5.4_-_PHP_(Good_Practices).pdf
A	documentos/Mod99/6866f3ef082cc_summary_exam.pdf

commit 7d5a49930ce63c8440135cbd6a3a209805a2a55a	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 19:54:10 2025 +0100

    atualizarPerfil

M	BLL/atualizarPerfil_bll.php
M	BLL/registoFuncionario_bll.php
M	DAL/atualizarPerfil_dal.php

commit 11557e335bae5338d128df687237793129aa2988	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 19:12:49 2025 +0100

    nada

M	BLL/registoFuncionario_bll.php

commit db5ffc6d2a67fc0ae048350d2f35dc9130c46419	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 18:55:14 2025 +0100

    atualizarperfil

M	BLL/atualizarPerfil_bll.php
M	BLL/registoFuncionario_bll.php
M	DAL/atualizarPerfil_dal.php

commit 3eb9afb4de503c37dd549bd46d62516053f5a65a	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 14:26:51 2025 +0100

    mini changes

M	BLL/perfil_bll.php
M	CSS/styleGlobal.css
M	UI/equipas.php

commit ca86bccd0b613aebf9f3e14ba0d61228bd6362b3	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 14:17:38 2025 +0100

    pausa de alguns min

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit 5d6f6da81b4ff9dfa6784cc8025007306be0355e	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 11:47:26 2025 +0100

    verificaçao de permissoes

M	BLL/atualizarPerfil_bll.php
M	BLL/perfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit 26225e99657662c946642ad71d26834b411be38b	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 11:13:14 2025 +0100

    mini fix perfil

M	BLL/perfil_bll.php
M	DAL/perfil_dal.php

commit 10f1fbee4e10518bd5d72f03940424f8f9ebc90d	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 11:03:12 2025 +0100

    atualizarPerfil fix some bug

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit 5ee749220b5ee6de94054a3ff45db7017e5cd579	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 10:50:37 2025 +0100

    mini change

M	CSS/styleAtualizarPerfil.css
M	CSS/styleGlobal.css

commit ea5cd321034879f319af5813d901aac595587e2f	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 10:34:42 2025 +0100

    css tentar colocar branco de fundo

M	UI/criarEquipa.php
M	UI/editarEquipa.php

commit 17b2f6fac931aea40adbbf8f92aff41a05671b60	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 10:15:52 2025 +0100

    eliminaçao de lixo

D	UI/teste.php
D	UI/ttt.html

commit 6f5efa977183342e58ce804053a348b955bb2e59	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Thu Jul 3 10:08:17 2025 +0100

    css editar equipa fundo branco

M	UI/editarEquipa.php

commit d9dff7c5ca58eeb35237a4862ddeba572b72cf1a	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 22:18:53 2025 +0100

    css almost finished

M	BLL/Permissoes.php
M	BLL/perfil_bll.php
M	DAL/visualizarFuncionario_dal.php
M	UI/admin/visualizarFuncionarios.php
M	UI/equipas.php
M	UI/perfil.php

commit 2302e514f41cd7dcd42bd546445dcee068e7550e	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 21:48:13 2025 +0100

    css changes

M	CSS/styleLogin.css
M	UI/criarEquipa.php
M	UI/editarEquipa.php

commit c245e770758915246236d5b3843da83bb957ddc4	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 19:10:28 2025 +0100

    style login

M	CSS/styleLogin.css
M	UI/login.php

commit 720fb0eb472f25da66f1ac9a27c183470a11990e	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 19:06:59 2025 +0100

    style atualizar perfil

M	CSS/styleAtualizarPerfil.css

commit 7964400b814b25825d0d7000d3a0a2e1aa317b9b	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 18:56:18 2025 +0100

    some changes

M	CSS/styleGlobal.css
M	CSS/stylePerfil.css
M	UI/atualizarPerfil.php
M	UI/perfil.php

commit 9f2d4a8b0ed0da93abf53caf67feedf60930baa6	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 18:50:04 2025 +0100

    equipas buttao de perfil

M	UI/equipas.php

commit 51ae2514b1e830ae98f854d4f201aae6d76059da	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 18:48:19 2025 +0100

    perfil style

M	CSS/stylePerfil.css

commit 1fdca2602f38dfcdd9f3572cf1e461368de62f64	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 18:43:07 2025 +0100

    side bar no permissoes

M	BLL/Permissoes.php
M	BLL/perfil_bll.php
M	UI/perfil.php

commit 88ac6e8484b0c5931ccb1fc71d54b37ed7373e70	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 18:33:09 2025 +0100

    logout in equipas

M	UI/equipas.php

commit d9174c6e0f0de2bc9e5cc72a8d07ffd7b67d9699	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 17:13:36 2025 +0100

    perfil changes cs not ready yet

M	BLL/perfil_bll.php
M	UI/perfil.php

commit 145c5c4390f895ad99981860e0ae9f87d36de08f	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 16:35:21 2025 +0100

    perfil bug fix

M	BLL/perfil_bll.php

commit 5442dcd4b43f53c7a3fd16da0289ad529eb65f7c	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 16:33:46 2025 +0100

    perfil bug fix

M	DAL/perfil_dal.php

commit 9060de84fc520bdee5c56afa1b31b0808b8231a4	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 15:47:59 2025 +0100

    commit

M	BLL/atualizarPerfil_bll.php
M	BLL/perfil_bll.php
M	DAL/perfil_dal.php

commit c920e25e58ca5731429a683506cb3f7bb068ab10	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 11:58:39 2025 +0100

    mini mini change just to end the morning

M	CSS/styleLogin.css

commit 3ecaed437b29bfd8b11fed1a743cc1468d08f2ac	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 11:54:31 2025 +0100

    some bugs fix

M	BLL/atualizarPerfil_bll.php
M	DAL/visualizarFuncionario_dal.php

commit 98a0cbcf838f0840fce452c684984b1191f646c1	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 11:49:22 2025 +0100

    atualizar viatura

M	BLL/atualizarPerfil_bll.php

commit 88fcdaeed38f2fc3cc389ddae57c2df961decc55	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 11:47:52 2025 +0100

    viatura atualizar

M	BLL/atualizarPerfil_bll.php

commit 9968a2fbb1e209b230e5ddd2fc951326fc1a8be2	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Wed Jul 2 10:56:36 2025 +0100

    atualizar perfil viatura

M	BLL/atualizarPerfil_bll.php

commit 6b5ecc4bf77d785a5480f0786168d4862416ef5f	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jul 1 19:17:28 2025 +0100

    atualizar perfil de outros

M	BLL/atualizarPerfil_bll.php
M	BLL/perfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit dcd054ffb6048070735716b8e32d7c1733efd80e	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jul 1 18:05:32 2025 +0100

    nada

M	BLL/visualizarFuncionario_bll.php

commit 094f80bd03ca6259513851977a817328d7c5528f	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Tue Jul 1 18:01:39 2025 +0100

    n sei o que aconteceu

M	BLL/visualizarFuncionario_bll.php

commit 7ccead867a8053f5c56d1a837e8fcfcd39e2a656	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 30 23:07:31 2025 +0100

    remoçao de botao inutil

M	UI/equipas.php

commit 9d70135e7bb5b7c76f1847e66ad034b99d1dcfdb	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 30 23:06:49 2025 +0100

    editar equipa funcional

M	UI/equipas.php

commit b31f82c35a4f1b3cb03f3919eb4d5697ea3eca82	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 30 22:56:33 2025 +0100

    voltar atras

M	BLL/criarEquipa_bll.php

commit 2e2b50324d3f60ff16682dcca38996154b0e4291	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 30 22:53:50 2025 +0100

    criarEquipa

M	BLL/criarEquipa_bll.php

commit 934e76ffc0a163e26e2435397a2c26cebd9b1c2d	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 30 22:36:43 2025 +0100

    criarEquipa e editarEquipa bug fix

M	BLL/criarEquipa_bll.php
M	BLL/editarEquipa_bll.php
M	DAL/editarEquipa_dal.php
M	UI/editarEquipa.php

commit 61c2b65ff2202a81aebcab76db873c2500643a42	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 30 17:26:44 2025 +0100

    editarEquipa pausa

M	BLL/editarEquipa_bll.php
M	UI/equipas.php

commit 2182b4a49da2bfa3414390d98413fad0cfbdfc95	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 30 16:38:51 2025 +0100

    editarEquipa falta testar

A	BLL/editarEquipa_bll.php
A	DAL/editarEquipa_dal.php
A	UI/editarEquipa.php
</pre>

</details>

#### 1231060@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /BLL/atribuirAlerta_bll.php                                                         |   30 
 /BLL/enviarEmail_bll.php                                                            |   47 
 /BLL/perfilConvidado_bll.php                                                        |  395 
 /BLL/registoConvidado_bll.php                                                       |  261 
 /BLL/visualizarFuncionario_bll.php                                                  |   41 
 /DAL/perfilConvidado_dal.php                                                        |  295 
 /UI/admin/enviarEmail.php                                                           |   29 
 /UI/admin/formularioConvidado.php                                                   |   16 
 /UI/admin/validarToken.php                                                          |   22 
 BLL/alertas_bll.php                                                                 |   82 
 BLL/atualizarPerfil_bll.php                                                         |    5 
 BLL/perfilConvidado_bll.php                                                         |   20 
 BLL/perfil_bll.php                                                                  |    2 
 BLL/registoFuncionario_bll.php                                                      |   74 
 BLL/visualizarFuncionario_bll.php                                                   |  109 
 DAL/atualizarPerfil_dal.php                                                         |    1 
 DAL/perfilConvidado_dal.php                                                         |   20 
 DAL/registoFuncionario_dal.php                                                      |   75 
 DAL/visualizarFuncionario_dal.php                                                   |   53 
 UI/admin/admin.php                                                                  |    3 
 UI/admin/formTeste.php                                                              |   22 
 UI/admin/visualizarFuncionarios.php                                                 |    8 
 UI/guest.html                                                                       |    8 
 a/BLL/visualizarFuncionario_bll.php                                                 |   41 
 b/API/alertas_api.php                                                               |   34 
 b/BLL/Permissoes.php                                                                |    2 
 b/BLL/alertasAdmin_bll.php                                                          |   30 
 b/BLL/alertas_bll.php                                                               |    3 
 b/BLL/atribuirAlerta_bll.php                                                        |   13 
 b/BLL/atualizarPerfil_bll.php                                                       |    2 
 b/BLL/caminhoDocumentos_bll.php                                                     |    1 
 b/BLL/enviarEmail_bll.php                                                           |    2 
 b/BLL/login_bll.php                                                                 |    1 
 b/BLL/perfilConvidado_bll.php                                                       |   14 
 b/BLL/perfil_bll.php                                                                |   23 
 b/BLL/registoConvidado_bll.php                                                      |    5 
 b/BLL/registoFuncionario_bll.php                                                    |    2 
 b/BLL/token_bll.php                                                                 |   28 
 b/BLL/uploadDocumentos_bll.php                                                      |   41 
 b/BLL/visualizarConvidados_bll.php                                                  |   47 
 b/BLL/visualizarFuncionario_bll.php                                                 |    8 
 b/DAL/alertasAdmin_dal.php                                                          |   48 
 b/DAL/alertas_dal.php                                                               |  108 
 b/DAL/atualizarPerfil_dal.php                                                       |    1 
 b/DAL/perfilConvidado_dal.php                                                       |    6 
 b/DAL/perfil_dal.php                                                                |   10 
 b/DAL/registoConvidado_dal.php                                                      |  265 
 b/DAL/registoFuncionario_dal.php                                                    |    1 
 b/DAL/token_dal.php                                                                 |   34 
 b/DAL/visualizarConvidados_dal.php                                                  |   31 
 b/DAL/visualizarFuncionario_dal.php                                                 |    2 
 b/UI/admin/admin.php                                                                |    1 
 b/UI/admin/alertasAdmin.php                                                         |   51 
 b/UI/admin/enviarEmail.php                                                          |   39 
 b/UI/admin/formTeste.php                                                            |   22 
 b/UI/admin/formularioConvidado.php                                                  |   14 
 b/UI/admin/perfilConvidado.php                                                      |   23 
 b/UI/admin/registoFuncionario.php                                                   |    3 
 b/UI/admin/validarToken.php                                                         |    1 
 b/UI/admin/visualizarConvidados.php                                                 |   24 
 b/UI/admin/visualizarFuncionarios.php                                               |    1 
 b/UI/alertas.php                                                                    |   28 
 b/UI/equipas.php                                                                    |    1 
 b/UI/perfil.php                                                                     |    1 
 b/composer.json                                                                     |    5 
 b/composer.lock                                                                     |  100 
 b/documentos/CartaoCidadao/68678dde3e914_Flowchart_GESPR_M2.pdf                     |binary
 b/documentos/CartaoCidadao/documentoCC_6864124ae37c97.74461591.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866b1e8684f80.50451610.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866b2289dde63.65365362.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866b8a68c3c85.95096132.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866b9e0184875.61979768.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866bdf0d049a5.89703774.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866be9ca77cd5.27524629.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866bea3a4c4c0.68822614.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866c0824ee4c2.43491397.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866c11671dd50.91420612.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6866c1761fd780.63446890.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6867eddf64e293.99755615.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6867eeea5d1539.61299977.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6867f5bbb901f8.56771020.pdf                  |binary
 b/documentos/CartaoCidadao/documentoCC_6867ff281f4474.48991532.pdf                  |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6864124ae44133.93217214.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866b1e86a8874.62634417.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866b2289ee424.02367965.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866b8a68d9138.10538600.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866b9e018e4d5.96015031.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866bdf0d10742.62242470.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866be9ca7f6c6.94615338.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866bea3a5cc63.73235064.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866c0825090c7.98075135.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866c116725c90.34877471.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6866c176207f54.77975594.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6867eddf66dbc6.16216155.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6867eeea5dab53.02784157.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6867f5bbba0211.20552700.pdf |binary
 b/documentos/CartaoContinente/documentoCartaoContinente_6867ff282010e2.57060935.pdf |binary
 b/documentos/DocumentoBancario/documentoBancario_6864124ae401d1.53801282.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866b1e869e2e1.56888064.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866b2289e92c0.81255479.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866b8a68d2690.04204516.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866b9e018b020.65918047.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866bdf0d0d287.96512163.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866be9ca7cee7.35771270.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866bea3a57786.05703251.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866c082501936.88816016.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866c1167230b7.59822584.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6866c176204907.79126693.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6867eddf6656c7.16759382.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6867eeea5d8036.30306711.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6867f5bbb9abf5.46207910.pdf        |binary
 b/documentos/DocumentoBancario/documentoBancario_6867ff281fcba1.01893644.pdf        |binary
 b/documentos/Mod99/documentoMod99_6864124ae3b873.65079502.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866b1e8693747.94961356.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866b2289e3674.58428441.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866b8a68ccf90.94873255.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866b9e0188167.05659970.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866bdf0d08932.08732241.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866be9ca7a5e9.28754490.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866bea3a51b33.13143793.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866c0824f5e28.67930248.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866c116720666.85449260.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6866c176200ed4.77364046.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6867eddf658148.34053889.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6867eeea5d40d7.06290740.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6867f5bbb94666.22428625.pdf                       |binary
 b/documentos/Mod99/documentoMod99_6867ff281f8675.97010502.pdf                       |binary
 b/jvscript/alertas.js                                                               |   46 
 b/vendor/autoload.php                                                               |   22 
 b/vendor/composer/ClassLoader.php                                                   |  579 +
 b/vendor/composer/InstalledVersions.php                                             |  396 
 b/vendor/composer/LICENSE                                                           |   21 
 b/vendor/composer/autoload_classmap.php                                             |   10 
 b/vendor/composer/autoload_namespaces.php                                           |    9 
 b/vendor/composer/autoload_psr4.php                                                 |   10 
 b/vendor/composer/autoload_real.php                                                 |   38 
 b/vendor/composer/autoload_static.php                                               |   36 
 b/vendor/composer/installed.json                                                    |   90 
 b/vendor/composer/installed.php                                                     |   32 
 b/vendor/composer/platform_check.php                                                |   26 
 b/vendor/phpmailer/phpmailer/COMMITMENT                                             |   46 
 b/vendor/phpmailer/phpmailer/LICENSE                                                |  502 
 b/vendor/phpmailer/phpmailer/README.md                                              |  232 
 b/vendor/phpmailer/phpmailer/SECURITY.md                                            |   37 
 b/vendor/phpmailer/phpmailer/SMTPUTF8.md                                            |   48 
 b/vendor/phpmailer/phpmailer/VERSION                                                |    1 
 b/vendor/phpmailer/phpmailer/composer.json                                          |   80 
 b/vendor/phpmailer/phpmailer/get_oauth_token.php                                    |  182 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-af.php                         |   26 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ar.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-as.php                         |   35 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-az.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ba.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-be.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-bg.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-bn.php                         |   35 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ca.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-cs.php                         |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-da.php                         |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-de.php                         |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-el.php                         |   33 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-eo.php                         |   26 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-es.php                         |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-et.php                         |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-fa.php                         |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-fi.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-fo.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-fr.php                         |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-gl.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-he.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-hi.php                         |   35 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-hr.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-hu.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-hy.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-id.php                         |   31 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-it.php                         |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ja.php                         |   37 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ka.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ko.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ku.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-lt.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-lv.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-mg.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-mn.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ms.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-nb.php                         |   33 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-nl.php                         |   34 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-pl.php                         |   33 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-pt.php                         |   34 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php                      |   38 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ro.php                         |   33 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ru.php                         |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-si.php                         |   34 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sk.php                         |   30 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sl.php                         |   36 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sr.php                         |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sr_latn.php                    |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-sv.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-tl.php                         |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-tr.php                         |   38 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-uk.php                         |   28 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-ur.php                         |   30 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-vi.php                         |   27 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-zh.php                         |   29 
 b/vendor/phpmailer/phpmailer/language/phpmailer.lang-zh_cn.php                      |   36 
 b/vendor/phpmailer/phpmailer/src/DSNConfigurator.php                                |  245 
 b/vendor/phpmailer/phpmailer/src/Exception.php                                      |   40 
 b/vendor/phpmailer/phpmailer/src/OAuth.php                                          |  139 
 b/vendor/phpmailer/phpmailer/src/OAuthTokenProvider.php                             |   44 
 b/vendor/phpmailer/phpmailer/src/PHPMailer.php                                      | 5362 ++++++++++
 b/vendor/phpmailer/phpmailer/src/POP3.php                                           |  469 
 b/vendor/phpmailer/phpmailer/src/SMTP.php                                           | 1547 ++
 212 files changed, 14479 insertions(+), 112 deletions(-), 146 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit d67dcc05a713218ff02ad75dd648877c023a0428	refs/heads/main (HEAD -> main, tag: Sprint_3, origin/main, origin/HEAD)
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Sat Jul 5 22:28:48 2025 +0100

    bug fix

M	BLL/alertas_bll.php

commit 6f490ef47546b1602d7a316cf48386e71d74710e	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Sat Jul 5 22:07:51 2025 +0100

    Pagina alertas de funcionários
    
    Implementar a atribuição,visualização e remoção de alertas a funcionários pelos RH

A	API/alertas_api.php
M	BLL/alertas_bll.php
M	BLL/atribuirAlerta_bll.php
M	BLL/visualizarFuncionario_bll.php
M	DAL/alertas_dal.php
M	DAL/visualizarFuncionario_dal.php
M	UI/alertas.php
A	jvscript/alertas.js

commit aa6c53cb824fa28208aab8a252a84c9277fb7aad	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Sat Jul 5 19:39:58 2025 +0100

    atribuição de alertas a funcionários pelos RH
    
    atribuição de alertas a funcionários pelos RH

A	BLL/atribuirAlerta_bll.php
M	BLL/visualizarFuncionario_bll.php
M	DAL/visualizarFuncionario_dal.php

commit fb8beb34a1ba82c67abe5e912a924c2923c1bcfb	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Sat Jul 5 18:48:11 2025 +0100

    criar e editar alertas pelo admin
    
    criar e editar alertas pelo admin

A	BLL/alertasAdmin_bll.php
A	DAL/alertasAdmin_dal.php
M	UI/admin/admin.php
A	UI/admin/alertasAdmin.php

commit 1d02f8108ceb024cd2399508cc6478948c79c3fc	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Sat Jul 5 13:32:36 2025 +0100

    bug fix visualizar Funcionario
    
    bug fix visualizar Funcionario

M	UI/admin/visualizarFuncionarios.php

commit be6ed007c6128afe0a37169c463fef668ebb17a1	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Sat Jul 5 11:43:39 2025 +0100

    visualizar membros de equipa
    
    visualizar membros de equipa

M	BLL/visualizarFuncionario_bll.php
M	DAL/visualizarFuncionario_dal.php
M	UI/admin/visualizarFuncionarios.php
M	UI/equipas.php

commit 6f40da80c9b1237dad9385dcb1603b2af00fb3ff	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Fri Jul 4 19:33:34 2025 +0100

    Implementação de visualização do aniversário de funcionario
    
    Implementação de visualização do aniversário de funcionario

M	BLL/visualizarFuncionario_bll.php
M	DAL/visualizarFuncionario_dal.php

commit 286d90a523e5993f271eb99c0b7ef8efbd4e5b2a	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Fri Jul 4 17:23:29 2025 +0100

    eliminar formulario de convidado
    
    eliminar formulario de convidado

M	BLL/enviarEmail_bll.php
M	BLL/perfilConvidado_bll.php
M	BLL/registoConvidado_bll.php
M	BLL/registoFuncionario_bll.php
M	DAL/perfilConvidado_dal.php
A	documentos/CartaoCidadao/documentoCC_6867eddf64e293.99755615.pdf
A	documentos/CartaoCidadao/documentoCC_6867eeea5d1539.61299977.pdf
A	documentos/CartaoCidadao/documentoCC_6867f5bbb901f8.56771020.pdf
A	documentos/CartaoCidadao/documentoCC_6867ff281f4474.48991532.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6867eddf66dbc6.16216155.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6867eeea5dab53.02784157.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6867f5bbba0211.20552700.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6867ff282010e2.57060935.pdf
A	documentos/DocumentoBancario/documentoBancario_6867eddf6656c7.16759382.pdf
A	documentos/DocumentoBancario/documentoBancario_6867eeea5d8036.30306711.pdf
A	documentos/DocumentoBancario/documentoBancario_6867f5bbb9abf5.46207910.pdf
A	documentos/DocumentoBancario/documentoBancario_6867ff281fcba1.01893644.pdf
A	documentos/Mod99/documentoMod99_6867eddf658148.34053889.pdf
A	documentos/Mod99/documentoMod99_6867eeea5d40d7.06290740.pdf
A	documentos/Mod99/documentoMod99_6867f5bbb94666.22428625.pdf
A	documentos/Mod99/documentoMod99_6867ff281f8675.97010502.pdf

commit bf93eea9d15deb4fdf88aa2063c49ced73af16b6	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Fri Jul 4 10:22:19 2025 +0100

     Implementação de filtragem do perfil de convidado pelo RH
    
     Implementação de filtragem do perfil de convidado pelo RH

M	BLL/perfilConvidado_bll.php
M	DAL/perfilConvidado_dal.php

commit 3dbe66d1bafd94b6195e292670a82cbd0d72a867	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Fri Jul 4 09:18:30 2025 +0100

    bug fix registoFuncionario
    
    bug fix registoFuncionario

M	BLL/perfilConvidado_bll.php
M	DAL/registoFuncionario_dal.php
A	documentos/CartaoCidadao/68678dde3e914_Flowchart_GESPR_M2.pdf

commit 0bdbcf5b8f3f465a66dcc0e131069e971c19a5a2	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Thu Jul 3 23:37:39 2025 +0100

    vista de todos os convidados
    
    visualização de todos os convidados

M	BLL/atualizarPerfil_bll.php
A	BLL/perfilConvidado_bll.php
A	BLL/visualizarConvidados_bll.php
M	DAL/atualizarPerfil_dal.php
A	DAL/perfilConvidado_dal.php
A	DAL/visualizarConvidados_dal.php
M	UI/admin/admin.php
A	UI/admin/perfilConvidado.php
A	UI/admin/visualizarConvidados.php

commit 03e88832d0c1a2bf1794ea28e5e754f93b97ab4b	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Thu Jul 3 19:21:20 2025 +0100

    Implementar formulário para convidado
    
    Implementar formulário para convidado

A	BLL/registoConvidado_bll.php
A	DAL/registoConvidado_dal.php
M	UI/admin/admin.php
M	UI/admin/enviarEmail.php
D	UI/admin/formTeste.php
M	UI/admin/formularioConvidado.php
M	UI/admin/validarToken.php
A	documentos/CartaoCidadao/documentoCC_6866b1e8684f80.50451610.pdf
A	documentos/CartaoCidadao/documentoCC_6866b2289dde63.65365362.pdf
A	documentos/CartaoCidadao/documentoCC_6866b8a68c3c85.95096132.pdf
A	documentos/CartaoCidadao/documentoCC_6866b9e0184875.61979768.pdf
A	documentos/CartaoCidadao/documentoCC_6866bdf0d049a5.89703774.pdf
A	documentos/CartaoCidadao/documentoCC_6866be9ca77cd5.27524629.pdf
A	documentos/CartaoCidadao/documentoCC_6866bea3a4c4c0.68822614.pdf
A	documentos/CartaoCidadao/documentoCC_6866c0824ee4c2.43491397.pdf
A	documentos/CartaoCidadao/documentoCC_6866c11671dd50.91420612.pdf
A	documentos/CartaoCidadao/documentoCC_6866c1761fd780.63446890.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866b1e86a8874.62634417.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866b2289ee424.02367965.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866b8a68d9138.10538600.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866b9e018e4d5.96015031.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866bdf0d10742.62242470.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866be9ca7f6c6.94615338.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866bea3a5cc63.73235064.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866c0825090c7.98075135.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866c116725c90.34877471.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6866c176207f54.77975594.pdf
A	documentos/DocumentoBancario/documentoBancario_6866b1e869e2e1.56888064.pdf
A	documentos/DocumentoBancario/documentoBancario_6866b2289e92c0.81255479.pdf
A	documentos/DocumentoBancario/documentoBancario_6866b8a68d2690.04204516.pdf
A	documentos/DocumentoBancario/documentoBancario_6866b9e018b020.65918047.pdf
A	documentos/DocumentoBancario/documentoBancario_6866bdf0d0d287.96512163.pdf
A	documentos/DocumentoBancario/documentoBancario_6866be9ca7cee7.35771270.pdf
A	documentos/DocumentoBancario/documentoBancario_6866bea3a57786.05703251.pdf
A	documentos/DocumentoBancario/documentoBancario_6866c082501936.88816016.pdf
A	documentos/DocumentoBancario/documentoBancario_6866c1167230b7.59822584.pdf
A	documentos/DocumentoBancario/documentoBancario_6866c176204907.79126693.pdf
A	documentos/Mod99/documentoMod99_6866b1e8693747.94961356.pdf
A	documentos/Mod99/documentoMod99_6866b2289e3674.58428441.pdf
A	documentos/Mod99/documentoMod99_6866b8a68ccf90.94873255.pdf
A	documentos/Mod99/documentoMod99_6866b9e0188167.05659970.pdf
A	documentos/Mod99/documentoMod99_6866bdf0d08932.08732241.pdf
A	documentos/Mod99/documentoMod99_6866be9ca7a5e9.28754490.pdf
A	documentos/Mod99/documentoMod99_6866bea3a51b33.13143793.pdf
A	documentos/Mod99/documentoMod99_6866c0824f5e28.67930248.pdf
A	documentos/Mod99/documentoMod99_6866c116720666.85449260.pdf
A	documentos/Mod99/documentoMod99_6866c176200ed4.77364046.pdf

commit c2d64762fe2456b2d5c9132650d1e9a45d8c0de1	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jul 2 23:43:46 2025 +0100

    envio de email funcional
    
    envio de email funcional, criação e validação do token de utilização unica.

A	BLL/enviarEmail_bll.php
A	BLL/token_bll.php
M	DAL/registoFuncionario_dal.php
A	DAL/token_dal.php
M	UI/admin/admin.php
A	UI/admin/enviarEmail.php
A	UI/admin/formTeste.php
A	UI/admin/formularioConvidado.php
M	UI/admin/registoFuncionario.php
A	UI/admin/validarToken.php
D	UI/guest.html
A	composer.json
A	composer.lock
A	vendor/autoload.php
A	vendor/composer/ClassLoader.php
A	vendor/composer/InstalledVersions.php
A	vendor/composer/LICENSE
A	vendor/composer/autoload_classmap.php
A	vendor/composer/autoload_namespaces.php
A	vendor/composer/autoload_psr4.php
A	vendor/composer/autoload_real.php
A	vendor/composer/autoload_static.php
A	vendor/composer/installed.json
A	vendor/composer/installed.php
A	vendor/composer/platform_check.php
A	vendor/phpmailer/phpmailer/COMMITMENT
A	vendor/phpmailer/phpmailer/LICENSE
A	vendor/phpmailer/phpmailer/README.md
A	vendor/phpmailer/phpmailer/SECURITY.md
A	vendor/phpmailer/phpmailer/SMTPUTF8.md
A	vendor/phpmailer/phpmailer/VERSION
A	vendor/phpmailer/phpmailer/composer.json
A	vendor/phpmailer/phpmailer/get_oauth_token.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-af.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ar.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-as.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-az.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ba.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-be.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-bg.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-bn.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ca.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-cs.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-da.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-de.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-el.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-eo.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-es.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-et.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-fa.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-fi.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-fo.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-fr.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-gl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-he.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-hi.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-hr.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-hu.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-hy.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-id.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-it.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ja.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ka.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ko.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ku.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-lt.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-lv.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-mg.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-mn.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ms.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-nb.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-nl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-pl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-pt.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ro.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ru.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-si.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sk.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sr.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sr_latn.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-sv.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-tl.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-tr.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-uk.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-ur.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-vi.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-zh.php
A	vendor/phpmailer/phpmailer/language/phpmailer.lang-zh_cn.php
A	vendor/phpmailer/phpmailer/src/DSNConfigurator.php
A	vendor/phpmailer/phpmailer/src/Exception.php
A	vendor/phpmailer/phpmailer/src/OAuth.php
A	vendor/phpmailer/phpmailer/src/OAuthTokenProvider.php
A	vendor/phpmailer/phpmailer/src/PHPMailer.php
A	vendor/phpmailer/phpmailer/src/POP3.php
A	vendor/phpmailer/phpmailer/src/SMTP.php

commit 49a71d136a1ba099fac506903d00d2151a099694	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jul 2 10:56:34 2025 +0100

    fix atualizar perfil
    
    fix atualizar perfil

M	BLL/atualizarPerfil_bll.php
M	DAL/atualizarPerfil_dal.php

commit 6fa5bcec834c7dfd8bdbb8ff664854f8c490c9b7	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Wed Jul 2 10:36:46 2025 +0100

    mostrar documentos
    
    mostrar doumentos e clicar para ver já ta funcional

M	BLL/perfil_bll.php
M	DAL/perfil_dal.php

commit 07812ee7fa2155bff72024a099d038b695736a5c	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Tue Jul 1 18:38:21 2025 +0100

    bug fix perfil
    
    agora dá para visualizar o perfil dos outros funcionario caso sejamos rh

M	BLL/Permissoes.php
M	BLL/login_bll.php
M	BLL/perfil_bll.php
M	BLL/visualizarFuncionario_bll.php
M	UI/admin/visualizarFuncionarios.php
M	UI/perfil.php

commit f733edc80410ef1b0eade3b3e7f0d3abf4c181a2	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Tue Jul 1 18:04:15 2025 +0100

    apaguei sem querer visualizarFuncionario
    
    apaguei sem querer visualizarFuncionario

A	BLL/visualizarFuncionario_bll.php

commit 3707bbd9ddb578ef5cfbc808589952c6ded48f66	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Tue Jul 1 17:58:56 2025 +0100

    upload documentos
    
    upload documentos está funcional

R095	BLL/uploadDocumentos_bll.php	BLL/caminhoDocumentos_bll.php
M	BLL/registoFuncionario_bll.php
D	BLL/visualizarFuncionario_bll.php
M	DAL/registoFuncionario_dal.php
A	documentos/CartaoCidadao/documentoCC_6864124ae37c97.74461591.pdf
A	documentos/CartaoContinente/documentoCartaoContinente_6864124ae44133.93217214.pdf
A	documentos/DocumentoBancario/documentoBancario_6864124ae401d1.53801282.pdf
A	documentos/Mod99/documentoMod99_6864124ae3b873.65079502.pdf

commit a1de31b4c47c8af23897b0a811ad67ec230c6ca3	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Mon Jun 30 17:41:25 2025 +0100

    registoFuncionario
    
    No registoFuncionario adicionei a  opção de dar upload a ficheiros pdf

M	BLL/registoFuncionario_bll.php
A	BLL/uploadDocumentos_bll.php
M	DAL/registoFuncionario_dal.php
</pre>

</details>


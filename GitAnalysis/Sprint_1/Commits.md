# Commits by author
#### 1220893@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /login.html            |   24 ++++++++++++!
 Dicionário             |    6 +++
 UI/login.html          |   31 -----------------
 b/Dicionário           |    1 
 b/UI/guest.html        |    2 !
 b/UI/login.php         |   39 +++++++++++++++++++++
 b/UI/profile.html      |   12 ++++++
 b/bll/handle_login.php |   87 +++++++++++++++++++++++++++++++++++++++++++++++++
 b/css/style.css        |   15 --!!!!!
 b/dsl/connection.php   |    6 +++
 b/photos/logo.png      |binary
 css/style.css          |   87 +++++++++++++++++++++++++++++++++++++++++++++++++
 12 files changed, 260 insertions(+), 34 deletions(-), 16 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 0e243c27e012b4f152692894b39e65b0c0568600	refs/heads/main
Author: FCClara <1220893@isep.ipp.pt>
Date:   Thu Jun 19 18:39:54 2025 +0100

    login funcional e novo desgin

M	"Dicion\303\241rio"
D	UI/login.html
A	UI/login.php
A	bll/handle_login.php
M	css/style.css
A	dsl/connection.php

commit 4dbddc27409ad4fcbf158bbdabbf3ec6d9909361	refs/heads/main
Author: CClaara <1220893@isep.ipp.pt>
Date:   Tue Jun 17 19:51:21 2025 +0100

    design pagina login feito

M	"Dicion\303\241rio"
R066	UI/SignIn.html	UI/guest.html
M	UI/login.html
A	UI/profile.html
M	css/style.css
A	photos/logo.png
</pre>

</details>

#### 1230650@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 login.html |    2 +!
 1 file changed, 1 insertion(+), 1 modification(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit 99a64c55d2e3b00d28830b343eb7a8af5d96b9e3	refs/heads/main
Author: josemrp <1230650@isep.ipp.pt>
Date:   Wed Jun 18 23:24:46 2025 +0100

    </html>

M	UI/login.html
</pre>

</details>

#### 1230794@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 /UI/Equipas.html          |   72 ++++++++++++++++++++++++
 UI/Equipas.html           |    1 
 UI/profile.html           |   89 ++++++++++++++++++-!!!!!!!!!
 b/DAL/connection.php      |    9 +!!
 b/UI/Equipas.html         |    8 ++
 b/UI/profile.html         |    1 
 b/UI/updateProfile.html   |   86 ++++++++++++++++++++++++++++
 b/css/style.css           |    1 
 b/photos/CodeKEtchers.png |binary
 css/style.css             |  137 +++++++++++++++++++++++++++++++++++++++++!!!!
 10 files changed, 350 insertions(+), 3 deletions(-), 51 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit f327b3a4b8ee077bb589fa3827ee2b8c6368b342	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 18:29:20 2025 +0100

    updateProfile0.1

A	UI/updateProfile.html

commit fd7a7305af277b07df59634cb359018cb2280f0b	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 17:55:05 2025 +0100

    equipas0.6

M	UI/Equipas.html
M	css/style.css

commit 098ff7eb3b7d8d1385a169123973cf1ed6c843ab	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 17:45:52 2025 +0100

    equipas0.5

M	UI/Equipas.html
M	UI/profile.html
M	css/style.css

commit 90f7911e362343702e6006af6a006d2b10abb518	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 17:42:58 2025 +0100

    equipas

A	UI/Equipas.html
M	UI/profile.html
M	css/style.css

commit 234d805b668fc0f99ab6ad9f6cc13183a50d4fbc	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 15:22:37 2025 +0100

    profile html finish probably

M	UI/profile.html
M	css/style.css
A	photos/CodeKEtchers.png

commit b69d817404174f0e70e06e05ee268436ec19e48a	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 14:29:30 2025 +0100

    css

M	css/style.css

commit efd871cd00dc83599607a146bc1a2a6c969b720f	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 14:21:55 2025 +0100

    profile almost finish

M	DAL/connection.php
M	UI/profile.html
M	css/style.css

commit 0b89c1c34adaea122e4beaaf1569a1fb9b716aa2	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 12:42:52 2025 +0100

    profile update

M	UI/profile.html
M	css/style.css

commit e52dcfffdced90412108f0d70c040f0f80023c37	refs/heads/main
Author: Andre Goncalves <1230794@isep.ipp.pt>
Date:   Mon Jun 23 11:28:40 2025 +0100

    mudanca do profile

M	UI/profile.html
</pre>

</details>

#### 1231060@isep.ipp.pt
<details>
<summary>Diff</summary>

<pre>
 DAL/connection.php     |    2 -!
 b/DAL/connection.php   |    7 ++++!!!
 b/DAL/login_dal.php    |   28 ++++++++++++++++++++++++++++
 b/UI/login.php         |    1 !
 b/bll/handle_login.php |   25 ---------------------!!!!
 bll/handle_login.php   |    1 !
 connection.php         |    1 +
 7 files changed, 33 insertions(+), 22 deletions(-), 10 modifications(!)
</pre>
</details>
<details>
<summary>Commits</summary>

<pre>
commit bff3024a457d2e24f46e8c2b8c8a26f971f73506	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Mon Jun 23 15:22:57 2025 +0100

    correção login

M	DAL/connection.php
A	DAL/login_dal.php
M	bll/handle_login.php

commit 30fbfe59a97723e68af97a18d79a132c97f5cdde	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Mon Jun 23 14:27:14 2025 +0100

    fixed connection.php

M	DAL/connection.php

commit 3a308fd464ee3c88becb731abdeba1e00c0b0eb1	refs/heads/main
Author: Rui Mendes <1231060@isep.ipp.pt>
Date:   Mon Jun 23 11:25:55 2025 +0100

    Mudei nome das pastas

R090	dsl/connection.php	DAL/connection.php
M	UI/login.php
M	bll/handle_login.php
</pre>

</details>


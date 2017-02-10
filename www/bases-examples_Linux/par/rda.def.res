[FILE_LOCATION]

FILE DATABASE.*=%path_database%rda/data/rda.*
FILE rda.*=%path_database%rda/data/rda.*
FILE copies.*=%path_database%copies/data/copies.*
FILE loanobjects.*=%path_database%loanobjects/data/loanobjects.*
FILE trans.*=%path_database%trans/data/trans.*
FILE DATABASE.XML=%path_database%rda/pfts/lilXML.pft
FILE normal.pft=%path_database%rda/pfts/%lang%/rda_opac.pft
FILE standard.pft=%path_database%rda/pfts/%lang%/adrda.pft
FILE detailed.pft=%path_database%rda/pfts/%lang%/mrclte.pft
FILE descritores.pft=%path_database%rda/pfts/%lang%/descritores.pft
FILE SHORTCUT.IAH=%path_database%rda/pfts/shortcut.pft
FILE BOOKMARK.PFT=%path_database%rda/pfts/%lang%/bookmark.pft
FILE DBLIL_LINK.PFT=%path_database%rda/pfts/%lang%/dblil_link.pft
FILE availability.pft=%path_database%rda/pfts/%lang%/availability.pft
FILE CITE.PFT=%path_database%rda/pfts/%lang%/cite.pft
FILE CALL_CITE.PFT=%path_database%rda/pfts/%lang%/call_cite.pft
FILE call_export_BibTex.pft=%path_database%rda/pfts/%lang%/call_export_BibTex.pft
FILE call_export_EndNote.pft=%path_database%rda/pfts/%lang%/call_export_EndNote.pft
FILE call_export_ProCite.pft=%path_database%rda/pfts/%lang%/call_export_ProCite.pft
FILE call_export_ReferenceManager.pft=%path_database%rda/pfts/%lang%/call_export_ReferenceManager.pft
FILE call_export_Refworks.pft=%path_database%rda/pfts/%lang%/call_export_Refworks.pft
FILE export_BibTex.pft=%path_database%rda/pfts/export_BibTex.pft
FILE export_EndNote.pft=%path_database%rda/pfts/export_EndNote.pft
FILE export_ProCite.pft=%path_database%rda/pfts/export_ProCite.pft
FILE export_ReferenceManager.pft=%path_database%rda/pfts/export_ReferenceManager.pft
FILE export_Refworks.pft=%path_database%rda/pfts/export_Refworks.pft
FILE GXML=%path_database%gizmo/gXML.*

[INDEX_DEFINITION]

INDEX Tw=^1Palavras^2Palabras^3Words^4Mots^d*^xBI ^uBI_^yDATABASE^mBI_
INDEX Tt=^1Palavras do t�tulo^2Palabras del t�tulo^3Title words^4Mots du titre^xTW ^uTW_^yDATABASE^mTW_
INDEX Ti=^1T�tulo^2T�tulo^3Title^4Titre^xTI ^uTI_^yDATABASE^mTI_
INDEX Ab=^1Palavras do resumo^2Palabras del resumen^3Abstract words^4R�sum� mots^xAB ^uAB_^yDATABASE^mAB_
INDEX Au=^1Autor^2Autor^3Author^4Auteur^xAU ^uAU_^yDATABASE^mAU_
INDEX Ai=^1Autor institucional^2Autor institucional^3Institutional author^4Institutionnel auteur^xAI ^uAI_^yDATABASE^mAI_
INDEX Ma=^1Assunto t�pico^2Descriptor^3Subject^4Sujet^xDE ^uDE_^yDATABASE^mDE_
INDEX Dg=^1Nome geogr�fico^2Descriptor geogr�fico^3Subject geographic^4Sujet g�ographique^xGD ^uGD_^yDATABASE^mGD_
INDEX KEY=^1Clave^2Clave^3KEY^4Clé^xKEY ^uKEY_^yDATABASE^mKEY_

[APPLY_GIZMO]


[FORMAT_NAME]

FORMAT normal.pft=^1Normal^2Normal^3Normal^4Normal
FORMAT standard.pft=^1Padr�o^2Largo^3Large^4Grand
FORMAT detailed.pft=^1Detalhado^2Detallado^3Detailed^4D�taill�e
FORMAT DEFAULT=normal.pft

[HELP_FORM]

HELP FORM=help_form_lilacs.htm
NOTE FORM=note_form1_lilacs.htm

[PREFERENCES]

AVAILABLE FORMS=F,A
SEND RESULT BY EMAIL=OFF
NAVIGATION BAR=OFF
DOCUMENTS PER PAGE=20
FEATURES=XML

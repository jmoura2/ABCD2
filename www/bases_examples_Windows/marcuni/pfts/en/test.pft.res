mpl,
'<table border=0 width=100%>'

if p(v100) then '<tr><td width=10% valign=top><font face=arial size=2><b>Personal Name</b></td><td valign=top><font face=arial size=2>',
 (if p(v100) then 
 | full name: |v100^a,
 |<br> first char only (0.1): |v100^a*0.1,
 |<br>  second char only (1.1): |v100^a*1.1,
 |<br> second char only (2.1): |v100^a*2.1,
 |<br> first 3 chars (0.3): |v100^a*0.3,
 |<br> first 5 chars (0.5): |v100^a*0.5,
 |<br> 2nd and 3rd char (1.2): |v100^a*1.2, 
 |<br> 2nd and 3rd char (mid): |mid(v100^a,1,2),  
 if iocc<>nocc(v100) then '<br>' fi 
 fi/),
'</td>' fi/

if p(v700) then '<tr><td width=10% valign=top><font face=arial size=2><b>Personal Name</b></td><td valign=top><font face=arial size=2>',
 (if p(v700) then 
 | full name:|v700^a,
 |<br> first char only (0.1):|v700^a*0.1,
 |<br>  second char only (1.1): |v700^a*1.1,
 |<br> second char only (2.1): |v700^a*2.1,
 |<br> first 3 chars (0.3): |v700^a*0.3,
 |<br> first 5 chars (0.5): |v700^a*0.5,
 |<br> 2nd and 3rd char (1.2): |v700^a*1.2,
 |<br> 2nd and 3rd char (mid): |mid(v700^a,1,2),  
 if iocc<>nocc(v700) then '<br>' fi 
 fi/),
'</td>' fi/

if p(v245) then '<tr><td width=10% valign=top><font face=arial size=2><b>Title statement</b></td>
 <td valign=top><font face=arial size=2>'
 (if p(v245) then v245^a,
  '<BR> first 5 chars of title with mid: 'mid(v245^a,0,5), 
  '<BR> last 5 chars of title with mid : 'mid(v245^a, size(v245^a)-5,5), 
  if iocc<>nocc(v245) then '<br>' fi 
  fi/),
'</td>' fi/

'</table><p>'

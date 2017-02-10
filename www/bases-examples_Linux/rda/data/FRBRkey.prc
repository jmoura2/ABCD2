'd911',
/* first define the unique identifier string in s1 */
s1:=( 
s(mhu,if p(v100^a) then v100^a else v110^a fi, 
if p(v130^a) then v130^a,|.|v130^m,|.|v130^n,|.|v130^r,|.|v130^f,|.|v130^g,|.|v130^p,|.|v130^k,|.|v130^o, 
else if p(v534^a) then v534^a,   
else if p(v240^a) then v240^a,|.|v240^m,|.|v240^n,|.|v240^r,|.|v240^f,|.|v240^g,|.|v240^p,|.|v240^k,|.|v240^o,
else v245^a,v245^b,v245^n,v245^p,
fi fi fi )
/* but take only first 100 characters due to CISIS limits */
*0.100),
/* then strip in s1 all non-alphanumerical chars */
     e1:=size(s1),
     e2:=1,
     s2:=(''),
     while e2<=e1
          (  if s('ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789'):mid(s1,e2,1)   /* you define the accecpted chars */
                 then s2:=(s2, mid(s1,e2,1) )
             fi,
          e2:=e2+1,
         )
/* finally put s2 into your field */
'<911>', s2, '</911>',
/* and produce the field itself as output */
/*   v911/ */  

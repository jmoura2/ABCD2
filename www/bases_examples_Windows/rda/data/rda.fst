1 0 "CN_"v1 
50 5 '/CL_/',"v50^a,|.|v50^b, 
20 5 '/IS_/',(v20^a/),(v22^a/) 
82 5 '/CL_/',(v82^a/) 
100 5 '/AU_/', (v100^a/),(v700^a/), if a(v100) then (replace(v245^c,'by ', ' ')) fi   /*is this correct ? e.g. Cuba : put other authors in v245^c and 1st author in v100 ???) */, (v110^a/)
100 8 '/AU_/', (v100^a/),(v700^a/), if a(v100) then (replace(v245^c,'by ', ' ')) fi   /*is this correct ? e.g. Cuba : put other authors in v245^c and 1st author in v100 ???) */, (v110^a/)
110 5 '/AI_/',(v110^a/) ,(v710^a/)
110 8 '/AI_/',(v110^a/) ,(v710^a/) 
111 5 '/CM_/',(v111^a/) ,(v711^a/) 
111 8 '/CM_/',(v111^a/) ,(v711^a/) 
245 5 '/TI_/',(v240^a/),(v242^a/),(v245^a/),(v773^t/),(v740^a/) 
245 8 '/TW_/',(v240^a/),(v242^a/),(v245^a/),(v773^t/),(v740^a/) 
260 5 '|PU_|',(v260^b/), 
260 8 '|PU_|',(v260^b/), 
260 5 '|PD_|',(v260^c/), (v8*7.4)
490 5 '/ST_/',(v490^a/) 
490 8 '\/ST_/',(v490^a/) 
500 8 '|AB_|',(v500^a/)
600 5 '|DE_|',(v600^a/) ,(v610^a/),(v611^a/)
650 5 '/DE_/' (v650^*/),
651 5 '/GD_/' (v651^*/), 
900 5 '|NI=|',(v900^n/) /* do we need this ??? */
999 8 '/BI_/', (v100^a/),(v110^a/),(v111^a/), (v600^a/),(v610^a/),(v611^a/), (v700^a/),(v710^a/),(v711^a/),
999 8 '/BI_/' ,(v240^a/),(v242^a/),(v245^a/),(v773^t/),(v740^a/)
999 8 '/BI_/' ,(v260^b/),(v490^a/), (v500^a/)
999 8 '/BI_/' , (v600^a/) ,(v610^a/),(v611^a/),(v650^a/),(v651^a/)
903 0 v1 
905 0 v100^a 
905 0 (v700^a/) 
905 0 v110^a 
905 0 v111^a 
945 0 v245^a 
960 0 v260^c 
888 5 '/KEY_/',if p(v130^a) then v130^a,|.|v130^m,|.|v130^n,|.|v130^r,|.|v130^f,|.|v130^g,|.|v130^p,|.|v130^k,|.|v130^o else if p(v240^a) then v240^a,|.|v240^m,|.|v240^n,|.|v240^r,|.|v240^f,|.|v240^g,|.|v240^p,|.|v240^k,|.|v240^o,if p(v100^a) then |.|v100^a else |.|v110^a fi else if p(v534^a) then v534^a,if p(v100^a) then |.|v100^a else |.|v110^a fi else v245^a,|.|v245^b,|.|v245^n,|.|v245^p ,if p(v100^a) then |.|v100^a else |.|v110^a fi fi fi fi
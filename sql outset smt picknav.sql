// ---------------- query firebird smt ---------------------------------------------------------------------//
/************************************************ page 1 ***********************************************************/

select status, noid, hostip, jobno, jobdate, jobtime, zfeeder, partnumber,
       demand, pol, pos, w_fs, p_sp, addrs, point, loose_reel, loose_reel_rl, loose_reel_qty,
       full_reel, full_reel_rl, full_reel_qty, ket,
       op_startnik, op_startname, op_startdate, op_starttime, op_endnik, op_endname,
       op_enddate, op_endtime, total_time
       from dl_picking_3(:startdate,:enddate)

select count(distinct jobno) as total_OLL
       from dl_picking_3(:startdate,:enddate)

select SUM(loose_reel_rl) as loose_reel_December, SUM(full_reel_rl) as full_reel_December
       from dl_picking_3(:startdate,:enddate)
       where loose_reel_rl is not null or full_reel_rl is not null
       
select distinct OP_STARTDATE, op_starttime,op_enddate, op_endtime
from jobdetail
where jobdate >= :startdate
and jobdate <= :enddate
and op_startdate is not null
group by OP_STARTDATE, op_starttime,op_enddate, op_endtime

 select distinct case upper(sts_opstart)
         when '1' then 'PROCESS'
         when '2' then 'CLEAR'
         when '3' then 'PASSED'
         when '4' then 'UNCLEAR'
         when '5' then 'UNCLEAR'
         else '-'
       end as status, noid, hostip, jobno, jobdate, jobtime, zfeeder,
       partnumber,
       demand, pol, pos,pos1, w_fs, p_sp, addrs, point, loose_reel,
       loose_reel_rl, loose_reel_qty,
       full_reel, full_reel_rl, full_reel_qty, ket,
       op_nik, op_name, op_startdate, op_starttime,
        case (op_endnik)
              when null then op_nik
              else op_endnik
       end as op_endnik,
       case (op_endname)
              when null then op_name
              else op_endname
       end as op_endname,
       op_enddate, op_endtime
       from jobdetail
       where jobdate >= :startdate
       and jobdate <= :enddate






select * from jobdetail where jobno containing '1F6C2AE5-A192-4772-A2B5-83C71708AA91'
select * from jobheaderinfo where jobno containing '1F6C2AE5-A192-4772-A2B5-83C71708AA91'
update jobheaderinfo set sts_install = '1' where jobno containing '1F6C2AE5-A192-4772-A2B5-83C71708AA91'



















select first 4 skip 0 zfeeder, pos, pos1, zfd_name, TRIM(LEADING '0' FROM zfd_no) as zfdno, zfd_tray, partnumber, checked

					from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-2')

					where (checked = '' or checked is null)

					order by pos, zfd_no asc
					
select *
						from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','')
						where (sts_checked = '1' or sts_checked is null)
						and checked is not null
						
select a.model, a.seqid, b.jobno, b.jobdate, b.jobtime, b.zfeeder,
        b.partnumber, b.demand, b.point, b.pol, b.pos, b.pos1, b.w_fs, b.p_sp, b.ket,
        c.checked, c.checked_nik, c.checked_name, c.checked_date, c.checked_time, c.sts_checked
        from jobmodel a left join jobdetail b on a.jobno = b.jobno
        left join checkedscan_new c on c.jobno = a.jobno and c.model = a.model and c.partnumber = b.partnumber
        where a.jobno = :jobno_in
        and a.seqid = :seqid_in
        and b.zfeeder containing :zfeeder_in
        
select ZFEEDER, POL, POS, W_FS, P_SP, PARTNUMBER, POINT, DEMAND, CHECKED, zfd_name, TRIM(LEADING '0' FROM zfd_no) as zfdno, zfd_tray from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-2') where (sts_checked = '1' or sts_checked is null) and checked is not null order by pos, zfeeder asc

select * from CHECKED_SLCTJOB('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-2')

select * from checkedscan_new
        where jobno = '2D8C0315-04B4-4F92-856F-FBA3034120E2'
        and seqid = '1'
        and checked_time = (select min(checked_time)from checkedscan_new
        where jobno = '2D8C0315-04B4-4F92-856F-FBA3034120E2'
        and seqid = '1')
        
        select distinct a.model, a.seqid, b.jobno, b.jobdate, b.jobtime, c.checked,
        c.sts_checked,
        (select * from checkedscan_new
                where jobno = :JOBNO
                and seqid = :seqid_in
                and checked_time = (select min(checked_time)
                                           from checkedscan_new
                                           where jobno = :JOBNO
                                           and seqid = '1'))
        from jobmodel a left join jobdetail b on a.jobno = b.jobno
        left join checkedscan_new c on c.jobno = a.jobno and c.model = a.model and c.partnumber = b.partnumber
        where a.jobno = :JOBNO
        and a.seqid = :seqid_in
        
        select distinct a.jobline, a.jobdate, a.jobtime, a.jobno, a.jobmodelname, b.pwb_name, b.process, a.jobstartserial, a.joblotsize, a.jobmc_program, a.jobpoint,a.jobefflot, a.sts_opstart, a.sts_install, a.sts_checked from jobheaderinfo a left join jobmodel b on a.jobno=b.jobno where a.jobdate='2017-11-18' order by (a.jobdate||a.jobtime) desc
        
select a.jobno, a.zfd_name, a.jobdate, a.jobtime,
(
       select max(b.sts_checked)
       from pn_checked_TABLE('4814C362-CD2A-453C-B1DE-921A280F2C7B','1') b
       where b.jobno = a.jobno
       and b.zfd_name = a.zfd_name
       and b.jobdate = a.jobdate
       and b.jobtime = a.jobtime
) as sts_checked2,
(
       select first 1 skip 0 c.checked_name
       from pn_checked_TABLE('4814C362-CD2A-453C-B1DE-921A280F2C7B','1') c
       where c.jobno = a.jobno
       and c.zfd_name = a.zfd_name
       and c.jobdate = a.jobdate
       and c.jobtime = a.jobtime
       order by jobdate, jobtime desc
) as checked_name2
from pn_checked_TABLE('4814C362-CD2A-453C-B1DE-921A280F2C7B','1') a
group by a.jobno, a.zfd_name, a.jobdate, a.jobtime


 select count(*) from confchecked
 where jobdate = '2017-11-20'
 and jobno = '4814C362-CD2A-453C-B1DE-921A280F2C7B'
 and seqid = '1'
 and zfd = 'NPM_M1 REAR'
 and confstart = 'OK'
 and confend = 'OK'











2D8C0315-04B4-4F92-856F-FBA3034120E2 NPM_M1 FRONT 11/20/2017 7:21:31 PM
select *
from pn_checked_TABLE('4814C362-CD2A-453C-B1DE-921A280F2C7B','1') b
where b.jobno = :jobno
and b.zfd_name = :zfdname
and b.jobdate = :jobdt
and b.jobtime = :jobtm



select distinct a.jobline, d.point, d.partnumber, a.jobmodelname,
c.jobno,b.pwb_name,b.process, a.jobpwbno,a.jobdate,a.jobtime,
a.jobstartserial, a.joblotsize, a.sts_opstart,a.sts_install,
a.sts_checked
from jobheaderinfo a
left join jobmodel b on a.jobno=b.jobno
left join joblist c on a.jobno=c.jobno
left join jobdetail d on a.jobno=d.jobno
where d.partnumber containing 'BD00C0AWFP 9'
and a.jobdate>='2017-11-20'
and a.jobdate<='2017-11-27'
and d.partnumber <> ''
order by (a.jobdate||a.jobtime) desc

select * from jobdetail
where partnumber = 'EN25F10100GI-X'
and jobdate >= '2017-10-01'
and jobdate <= '2017-10-31'


//=================================================================================================================================================
/************************************************************ page 2 *****************************************************************************/
//=================================================================================================================================================

select distinct jobno, zfd_name, jobdate, jobtime, sts_checked
from pn_checked_TABLE('2D8C0315-04B4-4F92-856F-FBA3034120E2','1')
group by jobno, zfd_name, jobdate, jobtime, sts_checked


select distinct a.jobno, a.zfd_name, a.jobdate, a.jobtime, a.sts_checked,
(
       select distinct b.checked_name
       from pn_checked_TABLE('2D8C0315-04B4-4F92-856F-FBA3034120E2','1') b
       group by b.jobno, b.zfd_name, b.jobdate, b.jobtime, b.sts_checked
) as chkname
from pn_checked_TABLE('2D8C0315-04B4-4F92-856F-FBA3034120E2','1') a
group by a.jobno, a.zfd_name, a.jobdate, a.jobtime, a.sts_checked

select a.checked_name, (SELECT MAX(b.checked_time) FROM pn_checked_JOINSCAN('2D8C0315-04B4-4F92-856F-FBA3034120E2','1',a.zfd_name) b ) as dt
from pn_checked_TABLE('2D8C0315-04B4-4F92-856F-FBA3034120E2','1') a
--where checked_time = cast(SELECT MAX(checked_time) FROM pn_checked_JOINSCAN('2D8C0315-04B4-4F92-856F-FBA3034120E2','1',zfd_name) AS DATE)
group by checked_name


SELECT checked_time FROM pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1', )


select distinct zfd_name, checked_name
from pn_checked_TABLE('2D8C0315-04B4-4F92-856F-FBA3034120E2','1')
--where checked_time = cast(SELECT MAX(checked_time) FROM pn_checked_JOINSCAN('2D8C0315-04B4-4F92-856F-FBA3034120E2','1',zfd_name) AS DATE)
group by zfd_name, checked_name



select * from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-3') where (sts_checked = '1' or sts_checked is null) and checked is null order by pos, zfd_no asc

select * from CHECKED_SLCTJOB('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-3') where TRIM(LEADING '0' FROM zfd_no) = '13' and pos = 'L'

//=================================================================================================================================================
/************************************************************ page 3 *****************************************************************************/
//=================================================================================================================================================
select first 1 skip 0 zfeeder, pos, pos1, partnumber, point,
TRIM(LEADING '0' FROM zfd_no) as zfdno, zfd_tray
from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-3')
where (sts_checked = '1' or sts_checked is null)
and checked is null
and TRIM(LEADING '0' FROM zfd_no) = '13'
and pos = 'R'
order by pos, zfd_no asc

select distinct model, line, start_serial, lot, filename, cavity
from jobmodel where jobno = '2D8C0315-04B4-4F92-856F-FBA3034120E2' and seqid = '1'

select jobdate, jobtime, jobline, jobpoint
from jobheaderinfo
where jobno = '2D8C0315-04B4-4F92-856F-FBA3034120E2'
and jobmodelname = 'NMZK-W67DFJN'

select Count(*) from checkedscan_new
where jobdate = '2017-01-01'
and jobno = '2D8C0315-04B4-4F92-856F-FBA3034120E2'
and seqid = '1'
and zfeeder = ''
and checktype = '1'
and modelid = 'NMZK-W67DFJN#301 ~ #2050MAXJ1182J01MN'
and model = 'NMZK-W67DFJN'
and partno containing 'CK73HBB1H102K 9'

select Count(*) from checkedscan_new
where jobdate = '2017-01-01'
and jobno = '2D8C0315-04B4-4F92-856F-FBA3034120E2'
and seqid = '1'
and zfeeder = ''
and checktype = '1'
and modelid = 'NMZK-W67DFJN#301 ~ #2050MAXJ1182J01MN'
and model = 'NMZK-W67DFJN'
and partno = 'CK73HBB1H102K 9tespertama yann'

select Count(*) from transdata
where mode = 'Mode4'
and line = 'SMT07'
and jobno = '2D8C0315-04B4-4F92-856F-FBA3034120E2'
and seqid = '1'
and model = 'NMZK-W67DFJN'
and modelid = 'NMZK-W67DFJN#301 ~ #2050MAXJ1182J01MN'
and startserial = '1001'
and barjvc = 'CK73HBB1H102K 9tespertama yann'




//=================================================================================================================================================
/************************************************************ page 4 *****************************************************************************/
//=================================================================================================================================================
select *
from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-3')
where (sts_checked = '1' or sts_checked is null)
order by pos, zfd_no asc

select distinct a.jobno, a.zfd_name, a.jobdate, a.jobtime,
(select max(b.sts_checked) from pn_checked_TABLE('2D8C0315-04B4-4F92-856F-FBA3034120E2','1') b
where b.jobno = a.jobno and b.zfd_name = a.zfd_name and b.jobdate = a.jobdate and
b.jobtime = a.jobtime) as sts_checked2
from pn_checked_TABLE('2D8C0315-04B4-4F92-856F-FBA3034120E2','1') a
group by a.jobno, a.zfd_name, a.jobdate, a.jobtime, a.sts_checked

select first 1 skip 0 zfeeder, pol, pos, pos1, partnumber, checked,
TRIM(LEADING '0' FROM zfd_no) as zfdno
from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-3')
where checked is null
and (sts_checked = '1' or sts_checked is null)
and TRIM(LEADING '0' FROM zfd_no) = '13' and pos = 'L'
order by pos, zfd_no asc

select jobno, model, seqid, line, start_serial, lot, filename, cavity
from jobmodel where jobno = '4814C362-CD2A-453C-B1DE-921A280F2C7B' and seqid = '1'

select sts_install,sts_opstart,jobno, jobdate, jobtime, jobfile, jobmc_program, jobmodelname,
jobpwbno, jobmetalmask, jobfirstpoint, jobpwbsize, jobefflot, jobblockjig,
 jobmcrh, jobline, joblotsize, jobstartserial, jobaltno
  from jobheaderinfo
   where jobno = '4814C362-CD2A-453C-B1DE-921A280F2C7B'
--    and (sts_install = '2' or sts_install = '3')
--    and (sts_opstart = '2' or sts_opstart = '3')
    and jobmodelname = 'MDV-D304WJN '
    
select sts_opstart, sts_install, jobno, jobdate, jobtime, jobfile, jobmc_program, jobmodelname, jobpwbno,
jobmetalmask, jobfirstpoint, jobpwbsize, jobefflot, jobblockjig, jobmcrh,
jobline, joblotsize, jobstartserial, jobaltno
from jobheaderinfo
where jobno = '4814C362-CD2A-453C-B1DE-921A280F2C7B'
and (sts_install > '1')
and (sts_opstart > '0')
and jobmodelname = 'MDV-D304WJN '


select distinct a.jobno, a.zfd_name, a.jobdate, a.jobtime,a.sts_checked,
(select max(b.sts_checked)
from pn_checked_TABLE('2D8C0315-04B4-4F92-856F-FBA3034120E2','1') b
where b.jobno = a.jobno
and b.zfd_name = a.zfd_name
and b.jobdate = a.jobdate
and b.jobtime = a.jobtime) as sts_checked2
from pn_checked_TABLE('4814C362-CD2A-453C-B1DE-921A280F2C7B','1') a
group by a.jobno, a.zfd_name, a.jobdate, a.jobtime, a.sts_checked



//=================================================================================================================================================
/************************************************************ page 5 *****************************************************************************/
//=================================================================================================================================================
select MODEL,SEQID,JOBNO,JOBDATE,JOBTIME,ZFEEDER,PARTNUMBER,POS,POS1,
ZFD_NAME,TRIM(LEADING '0' FROM zfd_no) as zfdno,ZFD_TRAY,ZFD,CHECKED,STS_CHECKED
from pn_checked_joinscan('4A0D067F-934D-413F-BFBB-F4FD1440D110','1','YSM20_1 (FRONT)')
where (sts_checked = '1' or sts_checked is null) and checked is null
and mod(TRIM(LEADING '0' FROM zfd_no),2) = 1


MODEL	SEQID	JOBNO	JOBDATE	JOBTIME	ZFEEDER	PARTNUMBER	POINT	DEMAND	POL	POS	POS1	W_FS	P_SP	KET	ZFD_NAME	ZFD_NO	ZFD_TRAY	SPOS_ZFDNM	EPOS_ZFDNM	SPOS_ZFDNO	EPOS_ZFDNO	ZFD	CHECKED	CHECKED_NIK	CHECKED_NAME	CHECKED_DATE	CHECKED_TIME	STS_CHECKED
					
					
select count(*) from confchecked
where jobdate = ''
and jobno = '4A0D067F-934D-413F-BFBB-F4FD1440D110'
and seqid = '1'
and zfd = 'YSM20_1 (FRONT)'
and confstart = 'OK'
and confend = 'OK'


//=================================================================================================================================================
/************************************************************ page 6 *****************************************************************************/
//=================================================================================================================================================
*checked nul
select first 1 skip 0 zfeeder, pol, pos, pos1, partnumber, checked,
TRIM(LEADING '0' FROM zfd_no) as zfdno
from pn_checked_joinscan('4814C362-CD2A-453C-B1DE-921A280F2C7B','1','NPM_M2 FRONT')
where
checked is null
and
(sts_checked = '1' or sts_checked is null)
order by pos, zfd_no asc

*notcheck 1
*checked
select first 1 skip 0 * from pn_checked_joinscan('4814C362-CD2A-453C-B1DE-921A280F2C7B','1','NPM_M2 FRONT')
where (sts_checked = '1' or sts_checked is null)
--and partnumber = 'ASDF'
order by pos, zfd_no asc

*checked
*sql_unchk_checked
select count(*) from pn_checked_joinscan('4814C362-CD2A-453C-B1DE-921A280F2C7B','1','NPM_M2 FRONT')
where (sts_checked = '1' or sts_checked is null) and (checked is null or checked = '')
and (partnumber <> null or partnumber <> '')

*tot_unchk_checked 39


//=================================================================================================================================================
/************************************************************ page 7 *****************************************************************************/
//=================================================================================================================================================
select count(*) from jobdetail

//=================================================================================================================================================
/************************************************************ page 8 *****************************************************************************/
//=================================================================================================================================================
select * from search_partno2(:jobno,:partno,:model,:sdate,:edate)
'EN25F10100GI-X'

select * from search_partno2('','EN25F10100GI-X','','','')

select * from search_partno3('','','') where jobdate>='2017-11-20' and jobdate<='2017-11-27'

select distinct a.jobline, d.point, d.partnumber, a.jobmodelname, c.jobno,
b.pwb_name,b.process, a.jobpwbno,a.jobdate,a.jobtime, a.jobstartserial,
 a.joblotsize, a.sts_opstart,a.sts_install,a.sts_checked
 from jobheaderinfo a
 left join jobmodel b on a.jobno=b.jobno
 left join joblist c on a.jobno=c.jobno
 left join jobdetail d on a.jobno=d.jobno
 WHERE a.JOBDATE = '2017-11-27' AND d.PARTNUMBER <> ''
 ORDER BY (a.jobdate||a.jobtime) desc
       order by (a.jobdate||a.jobtime) desc
       
select distinct a.jobline, d.point, d.partnumber, a.jobmodelname, c.jobno,b.pwb_name,b.process, a.jobpwbno,a.jobdate,a.jobtime, a.jobstartserial, a.joblotsize, a.sts_opstart,a.sts_install,a.sts_checked from jobheaderinfo a left join jobmodel b on a.jobno=b.jobno left join joblist c on a.jobno=c.jobno left join jobdetail d on a.jobno=d.jobno WHERE a.JOBDATE = '2017-11-27' AND d.PARTNUMBER CONTAINING 'EN25F10100GI-X' ORDER BY (a.jobdate||a.jobtime) desc

select * from search_partno2('','EN25F10100GI-X','','2017-10-01','2017-11-27')\

select distinct a.jobline, d.point, d.partnumber, a.jobmodelname, c.jobno,
b.pwb_name,b.process, a.jobpwbno,a.jobdate,a.jobtime, a.jobstartserial,
 a.joblotsize, a.sts_opstart,a.sts_install,a.sts_checked
 from jobheaderinfo a left join jobmodel b on a.jobno=b.jobno
 left join joblist c on a.jobno=c.jobno
 left join jobdetail d on a.jobno=d.jobno
 where d.partnumber containing 'EN25F10100GI-X'
 and a.jobdate>='2017-11-21'
 and a.jobdate<='2017-11-28'
 and d.partnumber <> ''
 
 select distinct a.jobline, d.point, d.partnumber, a.jobmodelname, c.jobno,b.pwb_name,b.process, a.jobpwbno,a.jobdate,a.jobtime, a.jobstartserial, a.joblotsize, a.sts_opstart,a.sts_install,a.sts_checked from jobheaderinfo a left join jobmodel b on a.jobno=b.jobno left join joblist c on a.jobno=c.jobno left join jobdetail d on a.jobno=d.jobno where a.jobdate='2017-11-28' and d.partnumber <> ''
 select * from jobdetail where partnumber = 'EN25F10100GI-X' order by jobdate desc
 
 select * from jobheaderinfo where jobno = '928518AF-FD23-419D-BB22-1DA807E25E79'
 select * from jobmodel where jobno = '928518AF-FD23-419D-BB22-1DA807E25E79'
 
 
 
*JOBLINE	*POINT	*PARTNUMBER	*JOBMODELNAME	*JOBNO	*PWB_NAME	*PROCESS	
*JOBPWBNO	*JOBDATE	*JOBTIME	*JOBSTARTSERIAL	*JOBLOTSIZE	*STS_OPSTART	*STS_INSTALL



*JOBMODELNAME	*JOBPWBNO *JOBLINE	*JOBLOTSIZE	*JOBSTARTSERIAL
*JOBNO	*JOBDATE	*JOBTIME       *PARTNUMBER          *POINT *STS_OPSTART          *STS_INSTALL
*PWB_NAME	*PROCESS


partno, jobno, startdate, model

partnumber = 'EN25F10100GI-X'

select distinct JOBNO,JOBDATE,JOBTIME,PARTNUMBER,POINT,STS_OPSTART,STS_INSTALL
from jobdetail where jobdate >= '2017-11-01' and jobdate <= '2017-11-30'
ORDER BY (jobdate||jobtime) desc

select distinct a.jobmodelname, a.jobpwbno, a.jobline, a.joblotsize, a.jobstartserial, b.pwb_name, b.process
from jobheaderinfo a left join jobmodel b on a.jobno  = b.jobno
where a.jobdate >= '2017-11-01' and a.jobdate <= '2017-11-30'
ORDER BY (a.jobdate||a.jobtime) desc

select distinct pwb_name, process from jobmodel
where jobdate >= '2017-11-01' and jobdate <= '2017-11-30'
ORDER BY (jobdate||jobtime) desc

where jobno = '73398AE8-2FFC-40E9-A116-E6A4F8D94C10'




//=================================================================================================================================================
/************************************************************ page 9 *****************************************************************************/
//=================================================================================================================================================

					
select distinct a.jobline, d.point, d.partnumber, a.jobmodelname,
					c.jobno,b.pwb_name,b.process,
					a.jobpwbno,a.jobdate,a.jobtime,
					a.jobstartserial, a.joblotsize,
					a.sts_opstart,a.sts_install,a.sts_checked
				from jobheaderinfo a
					left join jobmodel b on a.jobno=b.jobno
					left join joblist c on a.jobno=c.jobno
					left join jobdetail d on a.jobno=d.jobno
				where (d.partnumber containing 'LB73G0CB-005  9' or d.partnumber containing 'LB73G0FP-001  9')
					and a.jobdate>='2017-10-01'
					and  a.jobdate<='2017-12-18'
					and d.partnumber <> ''
					order by (a.jobdate||a.jobtime) desc
					
					
select distinct c.jobno,a.jobdate,a.jobtime,a.jobline,a.jobmodelname,b.pwb_name,
							a.jobpwbno,b.process, a.jobstartserial,a.joblotsize, a.jobfile,c.picname,a.sts_install,
							a.sts_ins_snik, a.sts_ins_sname, a.sts_ins_sdate, a.sts_ins_stime, a.sts_ins_edate, a.sts_ins_etime
						from jobheaderinfo a
							left join jobmodel b on a.jobno=b.jobno
							left join joblist c on a.jobno=c.jobno
						WHERE c.jobno = 'D6D2754D-3079-468F-9A8C-11E2EC424ADD'
							order by a.sts_install asc, a.jobline, (a.jobdate||a.jobtime) desc
							
							
select jobno, sts_install from jobheaderinfo where jobno = 'D6D2754D-3079-468F-9A8C-11E2EC424ADD'

//=================================================================================================================================================
/************************************************************ page 10 *****************************************************************************/
//=================================================================================================================================================
select first 1 skip 0 zfeeder, pos, pos1, partnumber, point,
TRIM(LEADING '0' FROM zfd_no) as zfdno, zfd_tray
from pn_checked_joinscan('CC388DB6-6ECE-4EB3-AFBA-87F78DA1D4B0','1','NPM_M1 FRONT')
where (sts_checked = '1' or sts_checked is null) and checked is null
and TRIM(LEADING '0' FROM zfd_no) = '13' order by pos, zfd_no asc

select first 1 skip 0 zfeeder, pos, pos1, partnumber, point,
						TRIM(LEADING '0' FROM zfd_no) as zfdno, zfd_tray
						from pn_checked_joinscan('8F4EC9C4-F2E6-40CC-8AFC-559E03168212','1','YV100Xg (FRONT)')
						where (sts_checked = '1' or sts_checked is null)
						and checked is null
						and TRIM(LEADING '0' FROM zfd_no) = '13'
					--	and pos = 'R'
						order by pos, zfd_no asc

select first 1 skip 0 zfeeder, pos, pos1, partnumber, point,
TRIM(LEADING '0' FROM zfd_no) as zfdno, zfd_tray
from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-1')
where (sts_checked = '1' or sts_checked is null) and checked is null
and TRIM(LEADING '0' FROM zfd_no) = '13' and pos is null order by pos, zfd_no

select *
from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-1')
where checked is null and TRIM(LEADING '0' FROM zfd_no) = '13'
and (sts_checked = '1' or sts_checked is null)
and pos is null order by pos, zfd_no


select zfeeder, pos, pos1, partnumber, point,
TRIM(LEADING '0' FROM zfd_no) as zfdno, zfd_tray
from pn_checked_joinscan('2D8C0315-04B4-4F92-856F-FBA3034120E2','1','CM402-1 TBL-1')
 where (sts_checked = '1' or sts_checked is null)
  and TRIM(LEADING '0' FROM zfd_no) = '13'
  order by pos, zfd_no asc
//=================================================================================================================================================
/************************************************************ page 11 *****************************************************************************/
//=================================================================================================================================================
select distinct a.jobline, d.point, d.partnumber, a.jobmodelname,
					c.jobno,b.pwb_name,b.process,
					a.jobpwbno,a.jobdate,a.jobtime,
					a.jobstartserial, a.joblotsize,
					a.sts_opstart,a.sts_install,a.sts_checked
				from jobheaderinfo a
					left join jobmodel b on a.jobno=b.jobno
					left join joblist c on a.jobno=c.jobno
					left join jobdetail d on a.jobno=d.jobno
				where (d.partnumber containing 'PIC95603      9')
					and a.jobdate>='2017-11-01'
					and  a.jobdate<='2018-01-05'
					and d.partnumber <> ''
					order by (a.jobdate||a.jobtime) desc
					
					select * from jobdetail where (partnumber containing 'PICA38603     9'
                or partnumber containing 'PICA38603-NV  8');
                
select * from jobdetail
						where jobno = '01353995-04D1-4B00-A985-BFAFD8D69541'
							and jobdate = '2018-01-01'
							and (sts_opstart = '2' or sts_opstart = '4')
							and ({$zno_feedergroup})
							
select distinct sts_opstart from jobdetail
						where jobno = '01353995-04D1-4B00-A985-BFAFD8D69541'
							and jobdate = '2018-01-10'
							and zfeeder containing 'CM402 TBL-1'
							and (partnumber <> '' or partnumber <> null)
						--	and (sts_opstart = '2')
//=================================================================================================================================================
/************************************************************ page 12 *****************************************************************************/
//=================================================================================================================================================
select zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc, full_reel,
full_reel_rl, full_reel_qty, full_reel_qty_blc, ket
from pn_picking('5799DCCA-8231-4412-84FF-51A29DB5CBC4')
where ( zfeeder containing 'YG200 (FRONT)'
or zfeeder containing 'YG200 (REAR)'
or zfeeder containing 'YV100Xg'
or zfeeder containing 'YV88XG')
and (partnumber <> ''
or partnumber <> null)
order by addrs asc


select distinct zfeeder from pn_picking_check('5799DCCA-8231-4412-84FF-51A29DB5CBC4')
								where zfeeder containing 'YG200 (FRONT)'
									and (partnumber <> null or partnumber <> '')
									and (sts_opstart = '1' or sts_opstart is null)
									and loose_reel is null
									and full_reel is null
									
select distinct zfeeder, pol, pos, pos1, w_fs, p_sp, addrs, partnumber, point, demand,
                        loose_reel, loose_reel_rl, loose_reel_qty, loose_reel_qty_blc,
                        full_reel, full_reel_rl, full_reel_qty, full_reel_qty_blc, ket,
                        op_nik,op_name, jobdate,jobtime,sts_opstart
        from  jobdetail
        where jobno = :jobno
select distinct *
        from  jobdetail
        where jobno = :jobno
              and (sts_opstart = '1' or sts_opstart is null)

update jobdetail set sts_opstart = '2',  where jobno = '5799DCCA-8231-4412-84FF-51A29DB5CBC4'
and (sts_opstart = '1' or sts_opstart is null)

select * from jobheaderinfo where jobno = '5799DCCA-8231-4412-84FF-51A29DB5CBC4'


select max(picking_time) from jobdetail
							where jobno = '5799DCCA-8231-4412-84FF-51A29DB5CBC4'
							and zfeeder containing 'YV88XG'

update jobdetail set
									sts_opstart = '2',
									op_enddate = '2018-01-11',
									op_endtime = '11:27:34'
								where jobno = '5799DCCA-8231-4412-84FF-51A29DB5CBC4'
								and zfeeder containing 'YV88XG'
									
//=================================================================================================================================================
/************************************************************ page 13 *****************************************************************************/
//=================================================================================================================================================
-- UNPASS Picking
--select * from jobheaderinfo where jobdate = '2018-01-24' and jobno = 'CE1CC15E-A1BA-42F8-801A-72CD5E0BAB9C'
--update jobdetail set sts_opstart = null where jobdate = '2018-01-24' and jobno = 'CE1CC15E-A1BA-42F8-801A-72CD5E0BAB9C'
--update jobheaderinfo set sts_opstart = null where jobdate = '2018-01-24' and jobno = 'CE1CC15E-A1BA-42F8-801A-72CD5E0BAB9C'



//=================================================================================================================================================
/************************************************************ page 14 *****************************************************************************/
//=================================================================================================================================================
--download january 2018
select status, noid, hostip, jobno, jobdate, jobtime, zfeeder, partnumber,
       demand, pol, pos, w_fs, p_sp, addrs, point, loose_reel, loose_reel_rl, loose_reel_qty,
       full_reel, full_reel_rl, full_reel_qty, ket,
       op_startnik, op_startname, op_startdate, op_starttime, op_endnik, op_endname,
       op_enddate, op_endtime, total_time
       from dl_picking_3('2018-01-01','2018-01-31')
       
select count(distinct jobno) as total_OLL
       from dl_picking_3('2018-01-01','2018-01-31')
       
select SUM(loose_reel_rl) as loose_reel, SUM(full_reel_rl) as full_reel
       from dl_picking_3('2018-01-01','2018-01-31')
       where loose_reel_rl is not null or full_reel_rl is not null
       
--download february 2018
select status, noid, hostip, jobno, jobdate, jobtime, zfeeder, partnumber,
       demand, pol, pos, w_fs, p_sp, addrs, point, loose_reel, loose_reel_rl, loose_reel_qty,
       full_reel, full_reel_rl, full_reel_qty, ket,
       op_startnik, op_startname, op_startdate, op_starttime, op_endnik, op_endname,
       op_enddate, op_endtime, total_time
       from dl_picking_3('2018-02-01','2018-02-28');

select count(distinct jobno) as total_OLL
       from dl_picking_3('2018-02-01','2018-02-28');

select SUM(loose_reel_rl) as loose_reel, SUM(full_reel_rl) as full_reel
       from dl_picking_3('2018-02-01','2018-02-28')
       where loose_reel_rl is not null or full_reel_rl is not null;
       
       select getdate()
//=================================================================================================================================================
/************************************************************ page 15 *****************************************************************************/
//=================================================================================================================================================
select * from jobdetail
where partnumber = 'LB73G0BK-006  9'
and jobdate >= '2017-10-01'

JOBNO,	JOBDATE,	JOBTIME,	ZFEEDER,	PARTNUMBER,	FIRMNO,	DEMAND,	POL,	POS	POS1	
W_FS	P_SP	ADDRS	POINT	LOOSE_REEL	LOOSE_NIK	LOOSE_NAME	LOOSE_DATE	
LOOSE_TIME	FULL_REEL	FULL_NIK	FULL_NAME	FULL_DATE	FULL_TIME	
KET	KET_NIK	KET_NAME	KET_DATE	KET_TIME	STS_OPSTART	OP_NIK	
OP_NAME	OP_STARTDATE	OP_STARTTIME	INSTALL	INSTALL_NIK	INSTALL_NAME	INSTALL_DATE	
INSTALL_TIME	OP_ENDDATE	OP_ENDTIME	UNF_NIK	UNF_NAME	UNF_DATE	
UNF_TIME	LOOSE_REEL_RL	LOOSE_REEL_QTY	FULL_REEL_RL	FULL_REEL_QTY	LOOSE_REEL_QTY_BLC	
FULL_REEL_QTY_BLC	OP_ENDNIK	OP_ENDNAME	STS_INSTALL	STS_INS_NIK	STS_INS_NAME	
STS_INS_STARTDATE	STS_INS_STARTTIME	STS_INS_ENDNIK	STS_INS_ENDNAME	STS_INS_ENDDATE	
STS_INS_ENDTIME	CANCEL_INS_DATE	CANCEL_INS_TIME	PICKING_NIK	PICKING_NAME	PICKING_DATE	
PICKING_TIME	STS_CHECKED	STS_CHK_SNIK	STS_CHK_SNAME	STS_CHK_SDATE	STS_CHK_STIME	
STS_CHK_ENIK	STS_CHK_ENAME	STS_CHK_EDATE	STS_CHK_ETIME	CHECKED	CHK_NIK	CHK_NAME	
CHK_DATE	CHK_TIME	UNF_INSNIK	UNF_INSNAME	UNF_INSDATE	UNF_INSTIME	
UNP_PICKNIK	UNP_PICKNAME	UNP_PICKDATE	UNP_PICKTIME

select distinct a.jobline, d.point, d.partnumber, a.jobmodelname,
c.jobno,b.pwb_name,b.process, a.jobpwbno,a.jobdate,a.jobtime,
a.jobstartserial, a.joblotsize, a.sts_opstart,a.sts_install,
a.sts_checked
from jobheaderinfo a
left join jobmodel b on a.jobno=b.jobno
left join joblist c on a.jobno=c.jobno
left join jobdetail d on a.jobno=d.jobno
where d.partnumber containing 'LB73G0BK-006  9'
and a.jobdate>='2017-10-01'
and a.jobdate<='2017-10-31'
and d.partnumber <> ''
order by (a.jobdate||a.jobtime) desc

select distinct a.jobline, d.point, d.partnumber, a.jobmodelname,
c.jobno,b.pwb_name,b.process, a.jobpwbno,a.jobdate,a.jobtime,
a.jobstartserial, a.joblotsize, a.sts_opstart,a.sts_install,
a.sts_checked
from jobheaderinfo a
left join jobmodel b on a.jobno=b.jobno
left join joblist c on a.jobno=c.jobno
left join jobdetail d on a.jobno=d.jobno
where d.partnumber containing 'NQR0269-030X'
and a.jobdate>='2018-01-01'
and a.jobdate<='2018-01-31'
and d.partnumber <> ''
order by (a.jobdate||a.jobtime) desc
//=================================================================================================================================================
/************************************************************ page 16 *****************************************************************************/
//=================================================================================================================================================
select distinct a.jobline, d.point, d.partnumber, a.jobmodelname,
					c.jobno,b.pwb_name,b.process,
					a.jobpwbno,a.jobdate,a.jobtime,
					a.jobstartserial, a.joblotsize,
					a.sts_opstart,a.sts_install,a.sts_checked
				from jobheaderinfo a
					left join jobmodel b on a.jobno=b.jobno
					left join joblist c on a.jobno=c.jobno
					left join jobdetail d on a.jobno=d.jobno
				where  a.jobmodelname containing ''
						and d.partnumber containing ''
						and c.jobno containing ''
						and a.jobdate>='2018-03-13'
						and  a.jobdate<='2018-03-13'
						and d.partnumber <> ''
					order by (a.jobdate||a.jobtime) desc
					
select * from jobdetail where jobdate='2018-03-14' and partnumber containing 'CD04DK0J151M  7'
select * from jobmodel where jobdate='2018-03-14' and model = 'KDC-U2063MD'					
					


//=================================================================================================================================================
/************************************************************ page 17 *****************************************************************************/
//=================================================================================================================================================
begin
     -- jobno model partno
     -- 000
     if ((JOBNO_IN is null) and (MODEL_IN is null) and (PARTNO_IN is null))
     6then begin
         FOR
           SELECT DISTINCT a.jobline, d.point, d.partnumber, a.jobmodelname,
                             c.jobno,b.pwb_name,b.process,
                          a.jobpwbno,a.jobdate,a.jobtime,
                        a.jobstartserial, a.joblotsize,
                         a.sts_opstart,a.sts_install
              FROM jobheaderinfo a
                   left join jobmodel b on a.jobno=b.jobno
                   left join joblist c on a.jobno=c.jobno
                   left join jobdetail d on a.jobno=d.jobno
              WHERE d.PARTNUMBER <> ''
             --- ORDER BY (a.jobdate||a.jobtime) desc
         INTO jobline, point, partnumber, jobmodelname, jobno, pwb_name, process,
              jobpwbno, jobdate, jobtime, jobstartserial, joblotsize, sts_opstart,
              sts_install
         DO
           BEGIN
                SUSPEND;
           END
       end
       -- jobno model partno
       -- 001
       else if ((JOBNO_IN is null) and (MODEL_IN is null) and (PARTNO_IN is not null) )
       then begin
            FOR
               SELECT DISTINCT a.jobline, d.point, d.partnumber, a.jobmodelname,
                             c.jobno,b.pwb_name,b.process,
                          a.jobpwbno,a.jobdate,a.jobtime,
                        a.jobstartserial, a.joblotsize,
                         a.sts_opstart,a.sts_install
               FROM jobheaderinfo a
                   left join jobmodel b on a.jobno=b.jobno
                   left join joblist c on a.jobno=c.jobno
                   left join jobdetail d on a.jobno=d.jobno
                WHERE d.PARTNUMBER CONTAINING :PARTNO_IN
              ---  ORDER BY (a.jobdate||a.jobtime) desc
                INTO jobline, point, partnumber, jobmodelname, jobno, pwb_name, process,
                     jobpwbno, jobdate, jobtime, jobstartserial, joblotsize, sts_opstart,
                     sts_install
         DO
           BEGIN
                SUSPEND;
           END
       end
--        jobno model partno
--        010
       else if ((JOBNO_IN is null) and (MODEL_IN is not null) and (PARTNO_IN is null) )
       then begin
            FOR
               SELECT DISTINCT a.jobline, d.point, d.partnumber, a.jobmodelname,
                             c.jobno,b.pwb_name,b.process,
                          a.jobpwbno,a.jobdate,a.jobtime,
                        a.jobstartserial, a.joblotsize,
                         a.sts_opstart,a.sts_install
               FROM jobheaderinfo a
                   left join jobmodel b on a.jobno=b.jobno
                   left join joblist c on a.jobno=c.jobno
                   left join jobdetail d on a.jobno=d.jobno
                WHERE a.jobdate>=:sdate and a.jobdate<=:edate and a.jobmodelname containing :MODEL_IN
                AND d.PARTNUMBER <> ''
              --  ORDER BY (a.jobdate||a.jobtime) desc
                INTO jobline, point, partnumber, jobmodelname, jobno, pwb_name, process,
                     jobpwbno, jobdate, jobtime, jobstartserial, joblotsize, sts_opstart,
                     sts_install
         DO
           BEGIN
                SUSPEND;
           END
       end
--        jobno model partno
--        011
       else if ((JOBNO_IN is null) and (MODEL_IN is not null) and (PARTNO_IN is not null) )
       then begin
            FOR
               SELECT DISTINCT a.jobline, d.point, d.partnumber, a.jobmodelname,
                             c.jobno,b.pwb_name,b.process,
                          a.jobpwbno,a.jobdate,a.jobtime,
                        a.jobstartserial, a.joblotsize,
                         a.sts_opstart,a.sts_install
               FROM jobheaderinfo a
                   left join jobmodel b on a.jobno=b.jobno
                   left join joblist c on a.jobno=c.jobno
                   left join jobdetail d on a.jobno=d.jobno
                WHERE a.jobmodelname containing :model_in
                AND d.PARTNUMBER containing :partno_in
             --   ORDER BY (a.jobdate||a.jobtime) desc
                INTO jobline, point, partnumber, jobmodelname, jobno, pwb_name, process,
                     jobpwbno, jobdate, jobtime, jobstartserial, joblotsize, sts_opstart,
                     sts_install
         DO
           BEGIN
                SUSPEND;
           END
       end
--        jobno model partno
--        100
       else if ((JOBNO_IN is not null) and (MODEL_IN is null) and (PARTNO_IN is null) )
       then begin
            FOR
               SELECT DISTINCT a.jobline, d.point, d.partnumber, a.jobmodelname,
                             c.jobno,b.pwb_name,b.process,
                          a.jobpwbno,a.jobdate,a.jobtime,
                        a.jobstartserial, a.joblotsize,
                         a.sts_opstart,a.sts_install
               FROM jobheaderinfo a
                   left join jobmodel b on a.jobno=b.jobno
                   left join joblist c on a.jobno=c.jobno
                   left join jobdetail d on a.jobno=d.jobno
                WHERE a.jobno containing :JOBNO_IN
                AND d.PARTNUMBER <> ''
              --  ORDER BY (a.jobdate||a.jobtime) desc
                INTO jobline, point, partnumber, jobmodelname, jobno, pwb_name, process,
                     jobpwbno, jobdate, jobtime, jobstartserial, joblotsize, sts_opstart,
                     sts_install
         DO
           BEGIN
                SUSPEND;
           END
       end
--        jobno model partno
--        101
       else if ((JOBNO_IN is not null) and (MODEL_IN is null) and (PARTNO_IN is not null) )
       then begin
            FOR
               SELECT DISTINCT a.jobline, d.point, d.partnumber, a.jobmodelname,
                             c.jobno,b.pwb_name,b.process,
                          a.jobpwbno,a.jobdate,a.jobtime,
                        a.jobstartserial, a.joblotsize,
                         a.sts_opstart,a.sts_install
               FROM jobheaderinfo a
                   left join jobmodel b on a.jobno=b.jobno
                   left join joblist c on a.jobno=c.jobno
                   left join jobdetail d on a.jobno=d.jobno
                WHERE a.jobno containing :JOBNO_IN
                AND d.PARTNUMBER containing :partno_in
              --  ORDER BY (a.jobdate||a.jobtime) desc
                INTO jobline, point, partnumber, jobmodelname, jobno, pwb_name, process,
                     jobpwbno, jobdate, jobtime, jobstartserial, joblotsize, sts_opstart,
                     sts_install
         DO
           BEGIN
                SUSPEND;
           END
       end
--        jobno model partno
--        110
       else if ((JOBNO_IN is not null) and (MODEL_IN is not null) and (PARTNO_IN is null) )
       then begin
            FOR
               SELECT DISTINCT a.jobline, d.point, d.partnumber, a.jobmodelname,
                             c.jobno,b.pwb_name,b.process,
                          a.jobpwbno,a.jobdate,a.jobtime,
                        a.jobstartserial, a.joblotsize,
                         a.sts_opstart,a.sts_install
               FROM jobheaderinfo a
                   left join jobmodel b on a.jobno=b.jobno
                   left join joblist c on a.jobno=c.jobno
                   left join jobdetail d on a.jobno=d.jobno
                WHERE a.jobno containing :JOBNO_IN
                AND a.jobmodelname containing :model_in
             --  ORDER BY (a.jobdate||a.jobtime) desc
                INTO jobline, point, partnumber, jobmodelname, jobno, pwb_name, process,
                     jobpwbno, jobdate, jobtime, jobstartserial, joblotsize, sts_opstart,
                     sts_install
         DO
           BEGIN
                SUSPEND;
           END
       end
--        jobno model partno
--        111
       else if ((JOBNO_IN is not null) and (MODEL_IN is not null) and (PARTNO_IN is not null) )
       then begin
            FOR
               SELECT DISTINCT a.jobline, d.point, d.partnumber, a.jobmodelname,
                             c.jobno,b.pwb_name,b.process,
                          a.jobpwbno,a.jobdate,a.jobtime,
                        a.jobstartserial, a.joblotsize,
                         a.sts_opstart,a.sts_install
               FROM jobheaderinfo a
                   left join jobmodel b on a.jobno=b.jobno
                   left join joblist c on a.jobno=c.jobno
                   left join jobdetail d on a.jobno=d.jobno
                WHERE a.jobno containing :JOBNO_IN
                AND a.jobmodelname containing :model_in
                AND d.PARTNUMBER containing :partno_in
             --   ORDER BY (a.jobdate||a.jobtime) desc
                INTO jobline, point, partnumber, jobmodelname, jobno, pwb_name, process,
                     jobpwbno, jobdate, jobtime, jobstartserial, joblotsize, sts_opstart,
                     sts_install
         DO
           BEGIN
                SUSPEND;
           END
       end
end
//=================================================================================================================================================
/************************************************************ page 18 *****************************************************************************/
//=================================================================================================================================================

select jobline, point, partnumber, jobmodelname, jobno, pwb_name,
 process, jobpwbno, jobdate, jobtime, jobstartserial, joblotsize,
 sts_opstart, sts_install from search_partno4('2018-03-14','2018-03-14','','','')
 
//=================================================================================================================================================
/************************************************************ page 19 *****************************************************************************/
//=================================================================================================================================================

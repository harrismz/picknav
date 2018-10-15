select distinct b.jobmodelname, a.status, b.joblotsize, b.jobstartserial,
(c.pwb_name ||'/'|| c.process) as process,
a.jobno, a.point, a.jobdate, a.jobtime, a.zfeeder, a.partnumber,
a.op_startnik, a.op_startname, a.op_startdate, a.op_starttime,
a.op_endnik, a.op_endname, a.op_enddate, a.op_endtime, a.total_time
from dl_picking(:startdate,:enddate) a
left join jobheaderinfo b on b.jobno = a.jobno
left join jobmodel c on c.jobno = a.jobno
order by partnumber, jobdate asc
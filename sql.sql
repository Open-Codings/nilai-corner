create table mahasiswa (
    mahasiswa_id number(11) not null,
    mahasiswa_nrp varchar2(50) not null,
    mahasiswa_nama varchar2(100) not null,
    primary key(mahasiswa_id)
)

create table mata_kuliah (
    mata_kuliah_id number(11) not null,
    mata_kuliah_nama varchar2(100) not null,
    mata_kuliah_deskripsi varchar2(500) not null,
    primary key(mata_kuliah_id)
)

create table mahasiswa_mata_kuliah (
    mahasiswa_mata_kuliah_id number(11) not null,
    mahasiswa_mata_kuliah_mahasiswa_id number(11) not null,
    mahasiswa_mata_kuliah_mata_kuliah_id number(11) not null,
    foreign key(mahasiswa_mata_kuliah_mahasiswa_id) references mahasiswa(mahasiswa_id),
    foreign key(mahasiswa_mata_kuliah_mata_kuliah_id) references mata_kuliah(mata_kuliah_id)
)

create table mahasiswa_nilai (
    mahasiswa_nilai_id number(11) not null,
    mahasiswa_nilai_mahasiswa_id number(11) not null,
    mahasiswa_nilai_mata_kuliah_id number(11) not null,
    mahasiswa_nilai_nilai number(11) not null,
    foreign key(mahasiswa_nilai_mahasiswa_id) references mahasiswa(mahasiswa_id),
    foreign key(mahasiswa_nilai_mata_kuliah_id) references mata_kuliah(mata_kuliah_id)
)

create or replace procedure p_mahasiswa 
(
    v_id mahasiswa.mahasiswa_id%type,
    v_nrp mahasiswa.mahasiswa_nrp%type,
    v_nama mahasiswa.mahasiswa_nama%type,
    v_opsi varchar2
)
is
begin
    if v_opsi = 'insert' then
        insert into mahasiswa values
            (v_id, v_nrp, v_nama);
        commit;
    elsif v_opsi = 'update' then
        update mahasiswa
            set mahasiswa_nrp=v_nrp, mahasiswa_nama=v_nama
        where mahasiswa_id=v_id;
        commit;
    elsif v_opsi = 'delete' then
        delete from mahasiswa where mahasiswa_id=v_id;
        commit;
    end if;
end p_mahasiswa;

create or replace procedure p_mata_kuliah
(
    v_id mata_kuliah.mata_kuliah_id%type,
    v_nama mata_kuliah.mata_kuliah_nama%type,
    v_deskripsi mata_kuliah.mata_kuliah_deskripsi%type,
    v_opsi varchar2
)
is
begin
    if v_opsi = 'insert' then
        insert into mata_kuliah values
            (v_id, v_nama, v_deskripsi);
        commit;
    elsif v_opsi = 'update' then
        update mata_kuliah 
            set mata_kuliah_nama=v_nama, mata_kuliah_deskripsi=v_deskripsi
        where mata_kuliah_id=v_id;
        commit;
    elsif v_opsi = 'delete' then
        delete from mata_kuliah
            where mata_kuliah_id=v_id;
        commit;
    end if;
end p_mata_kuliah;

create or replace procedure p_mahasiswa_mata_kuliah
(
    v_id mahasiswa_mata_kuliah.mahasiswa_mata_kuliah_id%type,
    v_mahasiswa mahasiswa_mata_kuliah.mahasiswa_mata_kuliah_mahasiswa_id%type,
    v_mata_kuliah mahasiswa_mata_kuliah.mahasiswa_mata_kuliah_mata_kuliah_id%type,
    v_opsi varchar2
)
is
begin
    if v_opsi = 'insert' then
        insert into mahasiswa_mata_kuliah values
            (v_id, v_mahasiswa, v_mata_kuliah);
        commit;
    elsif v_opsi = 'update' then
        update mahasiswa_mata_kuliah
            set mahasiswa_mata_kuliah_mahasiswa_id=v_mahasiswa, mahasiswa_mata_kuliah_mata_kuliah_id=v_mata_kuliah
        where mahasiswa_mata_kuliah_id=v_id;
        commit;
    elsif v_opsi = 'delete' then
        delete from mahasiswa_mata_kuliah
            where mahasiswa_mata_kuliah_mahasiswa_id=v_mahasiswa
                and mahasiswa_mata_kuliah_mata_kuliah_id=v_mata_kuliah;
        commit;
    elsif v_opsi = 'del_mahasiswa' then
        delete from mahasiswa_mata_kuliah
            where mahasiswa_mata_kuliah_mahasiswa_id=v_mahasiswa;
        commit;
    elsif v_opsi = 'del_mk' then
        delete from mahasiswa_mata_kuliah
            where mahasiswa_mata_kuliah_mata_kuliah_id=v_mata_kuliah;
        commit;
    end if;
end p_mahasiswa_mata_kuliah;

create or replace procedure p_mahasiswa_nilai
(
    v_id mahasiswa_nilai.mahasiswa_nilai_id%type,
    v_mahasiswa mahasiswa_nilai.mahasiswa_nilai_mahasiswa_id%type,
    v_mata_kuliah mahasiswa_nilai.mahasiswa_nilai_mata_kuliah_id%type,
    v_nilai mahasiswa_nilai.mahasiswa_nilai_nilai%type,
    v_opsi varchar2
)
is
begin
    if v_opsi = 'insert' then
        insert into mahasiswa_nilai values
            (v_id, v_mahasiswa, v_mata_kuliah, v_nilai);
        commit;
    elsif v_opsi = 'update' then
        update mahasiswa_nilai
            set mahasiswa_nilai_nilai=v_nilai
        where mahasiswa_nilai_mahasiswa_id=v_mahasiswa and mahasiswa_nilai_mata_kuliah_id=v_mata_kuliah;
        commit;
    elsif v_opsi = 'delete' then
        delete from mahasiswa_nilai
            where mahasiswa_nilai_id=v_id;
        commit;
    elsif v_opsi = 'del_mahasiswa' then
        delete from mahasiswa_nilai
            where mahasiswa_nilai_mahasiswa_id=v_mahasiswa;
        commit;
    elsif v_opsi = 'del_mk' then
        delete from mahasiswa_nilai
            where mahasiswa_nilai_mata_kuliah_id=v_mata_kuliah;
        commit;
    end if;
end p_mahasiswa_nilai;
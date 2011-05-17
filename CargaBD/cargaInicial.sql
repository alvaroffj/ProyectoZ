INSERT INTO TIPO_COMUNIDAD (NOM_TIPO_COMUNIDAD) VALUES ("Edificio"), ("Condominio");
INSERT INTO COMUNIDAD (ID_TIPO_COMUNIDAD, ID_COMUNA, NOM_COMUNIDAD, DIR_COMUNIDAD) VALUES (1, 300, "Edificio Seba", "Bilbao 3775");

INSERT INTO USUARIO (ID_COMUNIDAD, ID_TIPO_USUARIO, NOM_USUARIO, APE_USUARIO, DIR_USUARIO, USER_USUARIO, PASS_USUARIO, ESTADO_USUARIO) VALUES
                    (1, 1, "Alvaro", "Flores", "", "super.neeph@gmail.com", "eac74af5bb582afc34451a35c16335e5", 1),
                    (1, 1, "Sebastian", "Rios", "", "sebastianriosr@gmail.com", "eac74af5bb582afc34451a35c16335e5", 1);
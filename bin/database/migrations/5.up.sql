ALTER TABLE maps ADD repository_path TINYTEXT;
ALTER TABLE maps MODIFY COLUMN scale INT NULL DEFAULT NULL;
ALTER TABLE series ADD is_current BOOL DEFAULT true;

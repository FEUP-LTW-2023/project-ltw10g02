PRAGMA foreign_keys = on;
DROP TRIGGER IF EXISTS add_ticket_history;
CREATE TRIGGER add_ticket_history 
AFTER INSERT ON tickets
FOR EACH ROW
BEGIN
    INSERT INTO ticket_history (ticket_id, subject, description, status, priority, department_id, agent_id, faq_id)
    VALUES (NEW.id, NEW.subject, NEW.description, NEW.status, NEW.priority, NEW.department_id, NEW.agent_id, NEW.faq_id);
END;
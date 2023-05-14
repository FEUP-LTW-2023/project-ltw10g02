PRAGMA foreign_keys = on;
DROP TRIGGER IF EXISTS tr_tickets_history;
CREATE TRIGGER tr_tickets_history 
AFTER UPDATE ON tickets
FOR EACH ROW

WHEN OLD.subject <> NEW.subject
  OR OLD.description <> NEW.description 
  OR OLD.status <> NEW.status 
  OR OLD.priority <> NEW.priority 
  OR OLD.department_id <> NEW.department_id 
  OR OLD.agent_id <> NEW.agent_id 
  OR OLD.faq_id <> NEW.faq_id 
BEGIN  
  INSERT INTO ticket_history (ticket_id, subject, description, status, priority, department_id, agent_id, faq_id) 
  VALUES (NEW.id, NEW.subject, NEW.description, NEW.status, NEW.priority, NEW.department_id, NEW.agent_id, NEW.faq_id);
END;



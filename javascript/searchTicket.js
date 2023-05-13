function searchTicket(input_id, div_name, form_id, option) {
  const searchTicket = document.querySelector('#' + input_id);
  const searchForm = document.querySelector('#' + form_id)
  const departmentFormSearch = document.querySelector('#' + form_id + ' > ' + '.department_form_search')
  const statusFormSearch = document.querySelector('#' + form_id + ' > ' + '.status_form_search')
  const priorityFormSearch = document.querySelector('#' + form_id + ' > ' + '.priority_form_search')

  if (searchTicket && searchForm) {
    const fetchTickets = async () => {
      const response = await fetch(`../api/api_tickets_search.php?search=${searchTicket.value}&option=${option}&department=${departmentFormSearch.value}&status=${statusFormSearch.value}&priority=${priorityFormSearch.value}`);
      const tickets = await response.json();

      return tickets;
    };

    const renderTickets = (tickets) => {
      const ticketResumeSection = document.querySelector('#' + div_name);
      ticketResumeSection.innerHTML = '';

      for (const ticket of tickets) {
        /* Create elements */
        const article = document.createElement('article');

        const header = document.createElement('header');
        const anchorTicketPage = document.createElement('a');
        const ticketH2 = document.createElement('h2');
        const ticketStatus = document.createElement('p');
        const ticketDate = document.createElement('p');
        const ticketDescription = document.createElement('p');

        /* Create classes */
        article.classList.add('ticketResume');

        /* Assigning data */
        anchorTicketPage.href = `../pages/ticket.php?id=${ticket.id}`;
        anchorTicketPage.textContent = ticket.subject;
        ticketStatus.textContent = ticket.status;
        ticketDate.textContent = ticket.created_at;
        ticketDescription.textContent = ticket.description;

        /* Append Child */
        header.appendChild(ticketH2);
        header.appendChild(ticketStatus);
        ticketH2.appendChild(anchorTicketPage);

        article.appendChild(header);
        article.appendChild(ticketDate);
        article.appendChild(ticketDescription);

        ticketResumeSection.appendChild(article);
      }
    };

    searchTicket.addEventListener('input', async function () {
      const tickets = await fetchTickets();
      renderTickets(tickets);
    });

    searchForm.addEventListener('change', async function () {
      const tickets = await fetchTickets();
      renderTickets(tickets);
    });
  }
}

searchTicket('search_tickets_agent', 'my_tickets', 'form_my_tickets', 1)
searchTicket('search_tickets_client', 'my_tickets', 'form_my_tickets', 1)
searchTicket('search_deparment_tickets', 'department_tickets', 'form_department_tickets', 2)
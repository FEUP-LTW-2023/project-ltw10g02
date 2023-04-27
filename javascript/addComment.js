function addComment(){
    const formAddComment = document.querySelector('#add_comment')
    if (formAddComment) {
      formAddComment.addEventListener('submit', handleSubmit)
    }
  }
  
  async function handleSubmit(event) {
    event.preventDefault() // Evita que a página recarregue após enviar o formulário
  
    const formData = new FormData(this) // Obtém os dados do formulário
  
    const response = await fetch('../api/api_tickets_add_comment.php', {
        method: 'POST',
        body: formData
      })
    
    const formAddComment = document.querySelector('#add_comment')
    
    const article = document.createElement('article')
  
    const p = document.createElement('p')
  
    p.textContent = formData.get('comment')
  
    article.appendChild(p)
  
    formAddComment.insertAdjacentElement('beforebegin', article);
  
    // Remove o listener de envio de formulário anterior
    this.removeEventListener('submit', handleSubmit)
  }
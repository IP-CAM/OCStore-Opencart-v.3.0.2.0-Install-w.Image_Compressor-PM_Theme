class ReviewPagination {

  init(mainElement) {
    this.paginationLinkSelector = '.pagination a';

    mainElement.addEventListener('click', (evt) => {
      const linkElement = evt.target.closest(this.paginationLinkSelector);
      if (!linkElement || !linkElement.href) return;
      evt.preventDefault();

      fetch(linkElement.href)
        .then(response => {
          if (!response.ok) {
            throw new Error(`Код ответа: ${response.status}, сообщение: ${response.statusText}`);
          }
          return response.text();
        })
        .then(html => {
          mainElement.parentElement.parentElement.scrollIntoView();
          mainElement.innerHTML = html;
          window.yulms.reviewVote.checkVotedButtons();
        })
        .catch(console.error);
    });
  }
}


export default function initReviewPagination() {
  return new ReviewPagination();
}

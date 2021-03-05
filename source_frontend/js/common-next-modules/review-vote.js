'use strict';


class VoteReview {
  constructor() {
    this.selector = '[data-review-like]';
    this.dataAttrReviewId = 'reviewId';
    this.reviewIdSelector = '[data-review-id]';
    this.likedClass = 'reviews__vote-button--liked';
    this.voteCountSelector = '.reviews__vote-count';
    this.localStoragePropertyLike = 'liked-reviews';
    this.requestUrl = 'index.php?route=product/product/votereview';
    this.voteType = {
      LIKE: 'like',
      UNLIKE: 'unlike'
    };
    this.requestIsRunning = false;

    this.checkVotedButtons();

    document.addEventListener('click', (evt) => {
      const buttonElement = evt.target.closest(this.selector);
      if (!buttonElement) return;

      if (this.requestIsRunning) {
        return; // предыдущий запрос не выполнен
      } else {
        this.requestIsRunning = true;
      }

      const reviewId = +buttonElement.dataset[this.dataAttrReviewId];
      const voteType = buttonElement.classList.contains(this.likedClass) ? this.voteType.UNLIKE : this.voteType.LIKE;

      this._vote(reviewId, buttonElement, voteType)
        .then(() => this.requestIsRunning = false);
    });
  }


  checkVotedButtons() {
    const buttonElements = document.querySelectorAll(this.reviewIdSelector);
    buttonElements.forEach(button => {
      const reviewId = +button.dataset[this.dataAttrReviewId];

      if (this._isAlreadyVoted(reviewId)) {
        button.classList.add(this.likedClass);
      }
    });
  }


  _isAlreadyVoted(reviewId) {
    if (!localStorage[this.localStoragePropertyLike]) return;

    const propValue = localStorage.getItem([this.localStoragePropertyLike]);

    if (propValue) {
      const propValueArray = JSON.parse(propValue);
      return propValueArray.includes(reviewId);
    }
  }


  _vote(reviewId, buttonElement, voteType) {
    if (!reviewId) return;

    const countElement = buttonElement.querySelector(this.voteCountSelector);
    if (voteType === this.voteType.LIKE) {
      buttonElement.classList.add(this.likedClass);
      countElement.textContent++;
    } else {
      buttonElement.classList.remove(this.likedClass);
      countElement.textContent--;
    }

    const sendingData = new FormData;
    sendingData.append('review_id', reviewId);
    sendingData.append('vote', voteType);

    return fetch(this.requestUrl, {
      method: 'POST',
      headers: {'X-Requested-With': 'XMLHttpRequest'},
      body: sendingData
    })
      .then(response => {
        if (!response.ok) {
          throw Error(`${response.status} ${response.statusText}`);
        }
        return response.json();
      })
      .then(parsedData => {
        if (!parsedData.success) {
          throw Error('Ошибка сервера');
        } else {
          this._updateLocalStorage(reviewId, voteType);
        }
      });
  }


  _updateLocalStorage(reviewId, voteType) {
    const propName = this.localStoragePropertyLike;
    if (!localStorage[propName]) {
      localStorage.setItem(propName, '');
    }
    const currentValues = localStorage.getItem(propName);
    const currentValuesArr = (currentValues) ? JSON.parse(currentValues) : [];

    if (voteType === this.voteType.LIKE) {
      currentValuesArr.push(reviewId);
    } else {
      const reviewIdIndex = currentValuesArr.indexOf(reviewId);
      if (reviewIdIndex !== -1) {
        currentValuesArr.splice(reviewIdIndex, 1);
      }
    }

    localStorage.setItem(propName, JSON.stringify(currentValuesArr));
  }
}

new VoteReview;

/**
 * Documentation Page JavaScript
 */

(function() {
    'use strict';

    // ===== Smooth Scrolling for TOC Links =====
    const tocLinks = document.querySelectorAll('.table-of-contents a');

    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const headerOffset = 100; // Offset for fixed header
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                // Update active state
                tocLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });

    // ===== Auto-highlight TOC on Scroll =====
    const observerOptions = {
        root: null,
        rootMargin: '-100px 0px -66% 0px',
        threshold: 0
    };

    const observerCallback = (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.getAttribute('id');
                tocLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${id}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);

    // Observe all h2 headings (main sections)
    document.querySelectorAll('.article-body h2[id]').forEach(heading => {
        observer.observe(heading);
    });

    // ===== Sidebar Collapsing on Mobile =====
    const docSidebar = document.querySelector('.doc-sidebar');

    if (docSidebar && window.innerWidth < 968) {
        const sidebarToggle = document.createElement('button');
        sidebarToggle.className = 'sidebar-toggle';
        sidebarToggle.innerHTML = '☰ Menu';
        sidebarToggle.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            padding: 12px 20px;
            background: var(--color-primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        `;

        document.body.appendChild(sidebarToggle);

        sidebarToggle.addEventListener('click', function() {
            docSidebar.style.display = docSidebar.style.display === 'block' ? 'none' : 'block';
        });
    }

    // ===== Article Feedback Widget =====
    const feedbackSection = document.querySelector('.article-feedback');

    const storage = {
        get(key) {
            try {
                return window.localStorage.getItem(key);
            } catch (err) {
                return null;
            }
        },
        set(key, value) {
            try {
                window.localStorage.setItem(key, value);
            } catch (err) {
                // Ignore storage write issues
            }
        }
    };

    const generateUserId = () => {
        if (window.crypto && typeof window.crypto.randomUUID === 'function') {
            return window.crypto.randomUUID();
        }
        return 'uid-' + Math.random().toString(36).slice(2) + Date.now().toString(36);
    };

    let cachedUserId = null;
    const getUserId = () => {
        if (cachedUserId) {
            return cachedUserId;
        }
        const key = 'helpFeedbackUserId';
        let existing = storage.get(key);
        if (!existing) {
            existing = generateUserId();
            storage.set(key, existing);
        }
        cachedUserId = existing;
        return cachedUserId;
    };

    if (feedbackSection) {
        const buttons = feedbackSection.querySelectorAll('.btn-feedback');
        const statusEl = feedbackSection.querySelector('.feedback-status');
        const commentForm = feedbackSection.querySelector('.feedback-form');
        const commentTextarea = commentForm ? commentForm.querySelector('textarea') : null;
        const articlePath = feedbackSection.dataset.articlePath || '';
        const articleTitle = feedbackSection.dataset.articleTitle || document.title;
        const storageKey = articlePath ? `helpArticleFeedback:${articlePath}` : null;
        const commentStorageKey = storageKey ? `${storageKey}:commented` : null;
        const FEEDBACK_ENDPOINT = '/api/feedback.php';

        let isSubmittingVote = false;
        let isSubmittingComment = false;

        const state = {
            currentVote: null,
            commentSubmitted: false
        };

        const setStatus = (message) => {
            if (statusEl) {
                statusEl.textContent = message;
            }
        };

        const setButtonsDisabled = (disabled) => {
            buttons.forEach((btn) => {
                btn.disabled = disabled;
            });
        };

        const highlightVote = (vote) => {
            buttons.forEach((btn) => {
                if (vote && btn.dataset.helpful === vote) {
                    btn.classList.add('selected');
                } else {
                    btn.classList.remove('selected');
                }
            });
        };

        const persistVote = (vote) => {
            if (!storageKey) {
                return;
            }
            storage.set(storageKey, vote);
        };

        const persistCommentSubmission = () => {
            if (!commentStorageKey) {
                return;
            }
            storage.set(commentStorageKey, '1');
        };

        const showCommentForm = () => {
            if (!commentForm || state.commentSubmitted) {
                return;
            }
            commentForm.hidden = false;
            commentForm.classList.add('visible');
            if (commentTextarea && !commentTextarea.value) {
                commentTextarea.focus();
            }
        };

        const hideCommentForm = () => {
            if (!commentForm) {
                return;
            }
            commentForm.hidden = true;
            commentForm.classList.remove('visible');
        };

        const submitFeedback = ({ vote, recordVote = true, comment = '' }) => {
            const userId = getUserId();
            if (!userId) {
                return Promise.reject(new Error('Missing user identifier'));
            }

            const payload = {
                article: articlePath,
                vote,
                title: articleTitle,
                record_vote: recordVote,
                user_id: userId
            };

            if (comment) {
                payload.comment = comment;
            }

            return fetch(FEEDBACK_ENDPOINT, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin',
                body: JSON.stringify(payload)
            }).then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            });
        };

        const savedVote = storageKey ? storage.get(storageKey) : null;
        const savedCommented = commentStorageKey ? storage.get(commentStorageKey) === '1' : false;

        if (savedVote) {
            state.currentVote = savedVote;
            highlightVote(savedVote);
        }

        if (savedCommented) {
            state.commentSubmitted = true;
            hideCommentForm();
            if (savedVote) {
                setStatus('Thanks for sharing your feedback!');
            }
        } else if (savedVote === 'no') {
            showCommentForm();
            setStatus('Thanks for your feedback. Tell us what was missing?');
        } else if (savedVote) {
            setStatus('Thanks for your feedback!');
        }

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                const vote = button.dataset.helpful;
                if (!vote || !articlePath || isSubmittingVote) {
                    return;
                }

                const previousVote = state.currentVote;
                if (previousVote === vote) {
                    if (vote === 'no' && !state.commentSubmitted) {
                        showCommentForm();
                    }
                    return;
                }

                isSubmittingVote = true;
                setButtonsDisabled(true);
                highlightVote(vote);
                setStatus('Sending feedback...');

                submitFeedback({ vote, recordVote: true })
                    .then((data) => {
                        state.currentVote = vote;
                        persistVote(vote);

                        if (vote === 'no') {
                            if (!state.commentSubmitted) {
                                showCommentForm();
                                setStatus(data.message || 'Thanks for letting us know. Tell us what was missing?');
                            } else {
                                hideCommentForm();
                                setStatus(data.message || 'Thanks again for your feedback!');
                            }
                        } else {
                            hideCommentForm();
                            setStatus(data.message || 'Thanks for your feedback!');
                        }
                    })
                    .catch(() => {
                        setStatus('Something went wrong. Please try again.');
                        highlightVote(previousVote);
                    })
                    .finally(() => {
                        isSubmittingVote = false;
                        setButtonsDisabled(false);
                    });
            });
        });

        if (commentForm && commentTextarea) {
            commentForm.addEventListener('submit', (event) => {
                event.preventDefault();
                if (isSubmittingComment) {
                    return;
                }

                const details = commentTextarea.value.trim();
                if (!details) {
                    setStatus('Please share a few words so we can improve.');
                    return;
                }

                const voteForDetails = state.currentVote || 'no';
                const shouldRecordVote = !state.currentVote;

                isSubmittingComment = true;
                setStatus('Sending your feedback...');

                submitFeedback({
                    vote: voteForDetails,
                    recordVote: shouldRecordVote,
                    comment: details
                }).then((data) => {
                    setStatus(data.message || 'Thanks for sharing the extra context!');
                    commentTextarea.value = '';
                    state.currentVote = voteForDetails;
                    state.commentSubmitted = true;
                    persistVote(voteForDetails);
                    persistCommentSubmission();
                    highlightVote(voteForDetails);
                    hideCommentForm();
                }).catch(() => {
                    setStatus('Something went wrong. Please try again.');
                }).finally(() => {
                    isSubmittingComment = false;
                    setButtonsDisabled(false);
                });
            });
        }
    }


})();

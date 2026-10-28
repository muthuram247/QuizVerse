# QuizVerse — Stage 1

A mobile-friendly quiz game frontend for GitHub Pages.

## Included now
- Brain Mix and Tech Zone quizzes
- Countdown timer, scoring and answer feedback
- Sound effects and optional generated background tones
- Saved in-progress quiz using browser localStorage
- Personal leaderboard stored on this device

## Important limitations in Stage 1
- Google sign-in is a placeholder until Google OAuth and the PHP backend are configured.
- Scores are local to this browser, not shared online.
- Online multiplayer is not active yet.
- GitHub Pages does not execute PHP. Deploy the `backend/` folder to a separate PHP + MySQL host.

## Publish using an Android phone
1. Open https://github.com and sign in.
2. Tap **+** → **New repository**.
3. Repository name: `QuizVerse`; choose **Public**; tap **Create repository**.
4. In the new repository, tap **Add file** → **Create new file**.
5. Name it `index.html`.
6. Paste the full `index.html` from this package and commit the file.
7. Open **Settings** → **Pages**.
8. Under **Build and deployment**, choose **Deploy from a branch**.
9. Select branch `main` and folder `/(root)`, then **Save**.
10. Wait for the published URL shown on the Pages screen. It will normally look like `https://YOUR-USERNAME.github.io/QuizVerse/`.

## PHP backend
See `backend/README.md` and `backend/database/schema.sql`. Configure secrets only on the PHP hosting server; never put database passwords in `index.html`.

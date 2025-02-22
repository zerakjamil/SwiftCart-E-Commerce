# Contributing to SwiftCart E-commerce

First off, thank you for considering contributing to SwiftCart E-commerce. It's people like you that make SwiftCart E-commerce such a great tool.

## Where do I go from here?

If you've noticed a bug or have a feature request, make one! It's generally best if you get confirmation of your bug or approval for your feature request this way before starting to code.

## Fork & create a branch

If this is something you think you can fix, then fork SwiftCart E-commerce and create a branch with a descriptive name.

A good branch name would be (where issue #325 is the ticket you're working on):
git checkout -b 325-add-japanese-localization


## Get the test suite running

Make sure you're using the latest version of PHP and Composer. Then, install the dependencies and run the tests:

```bash
composer install
php artisan test

```
## Implement your fix or feature
At this point, you're ready to make your changes! Feel free to ask for help; everyone is a beginner at first.

## Make a Pull Request
At this point, you should switch back to your master branch and make sure it's up to date with Herd E-commerce's master branch:
```bash
git remote add upstream git@github.com:zerakjamil/SwiftCart-E-Commerce.git
git checkout master
git pull upstream master
```
Then update your feature branch from your local copy of master, and push it!
```bash
git checkout 325-add-japanese-localization
git rebase master
git push --set-upstream origin 325-add-japanese-localization
```
Finally, go to GitHub and make a Pull Request :D

## Keeping your Pull Request updated
If a maintainer asks you to "rebase" your PR, they're saying that a lot of code has changed, and that you need to update your branch so it's easier to merge.
To learn more about rebasing in Git, there are a lot of good resources but here's the suggested workflow:
```bash
git checkout 325-add-japanese-localization
git pull --rebase upstream master
git push --force-with-lease 325-add-japanese-localization
```

## Code review
I will review your pull request and provide feedback. Please be patient as pull requests are often reviewed in batches.

## Guidelines
- Write clear, concise commit messages.
- Include tests for new features and bug fixes.
- Follow the existing code style and conventions.
- Keep your changes focused. If you have multiple unrelated changes, submit them as separate pull requests.
- Document your code and update any relevant documentation.
- Make sure your code passes all tests before submitting a pull request.

## Code of Conduct
Please note that this project is released with a Contributor Code of Conduct. By participating in this project you agree to abide by its terms.

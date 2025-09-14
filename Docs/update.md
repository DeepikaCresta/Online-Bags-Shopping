# Instruction 1

These instruction are used when you already have the running project but needs to get the new changes that are in the github. If you are clonning then you don't need to run these below command. You will have to run different set of commands.

## Step 1

In the left corner of vs code you will see the git branch you are in. Or run below command in terminal

```
git branch
```
Above command will give you branch list. If the * is not in the main then run the below command. If the * is in main then you can skip the step 1.

```
git checkout main
```

## Step 2

After you are sure you are in main branch. Also make sure there are no changes in your files otherwise there might occure the git conflict.

```
git pull

```

## Step 3

```
php artisan migrate
composer update
composer dump-autoload

```
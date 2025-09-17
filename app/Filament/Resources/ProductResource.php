<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Livewire\TemporaryUploadedFile;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\Pages\EditProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Filament\Resources\CategoryResource\RelationManagers\CategoriesRelationManager;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Shop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                TextInput::make('SKU')
                    ->helperText('SKU be like this SKU-####')
                    ->regex('/SKU-\d{4}/')
                    ->required(),

                TextInput::make('price')
                    ->numeric()
                    ->prefix('Rs.')
                    ->rules(['min:0'])
                    ->required(),

                TextInput::make('old_price')
                    ->numeric()
                    ->prefix('Rs.')
                    ->rules(['min:0'])
                    ->required(),

                TextInput::make('shipping_cost') // NEW FIELD
                    ->numeric()
                    ->prefix('Rs.')
                    ->rules(['min:0'])
                    ->required(),

                TextInput::make('quantity')->numeric(),

                TextInput::make('brief_description')
                    ->rules(['min:10', 'max:100'])
                    ->required(),

                Select::make('stock_status')->options([
                    'instock' => 'In Stock',
                    'outstock' => 'Out of Stock',
                ])->default('instock'),

                FileUpload::make('image')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $fileName = $file->hashName();
                        $name = explode('.', $fileName);
                        return (string) str('images/products/main_image/' . $name[0] . '.' . $name[1]);
                    })
                    ->label('Main Image')
                    ->maxSize(3072)
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('450')
                    ->imageResizeTargetHeight('450')
                    ->required(),

                FileUpload::make('images')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $fileName = $file->hashName();
                        $name = explode('.', $fileName);
                        return (string) str('images/products/alt_images/' . $name[0] . '.' . $name[1]);
                    })
                    ->columnSpan('full')
                    ->label('Alternate Images')
                    ->maxSize(3072)
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('450')
                    ->imageResizeTargetHeight('450')
                    ->required(),

                RichEditor::make('description')
                    ->maxLength(1000)
                    ->columnSpan('full')
                    ->toolbarButtons([
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'undo',
                    ]),

                CheckboxList::make('categories')
                    ->columnSpan('full')
                    ->relationship('categories', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                FilamentExportHeaderAction::make('export')
            ])
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('SKU')->searchable()->sortable(),
                TextColumn::make('price')->prefix('Rs.')->sortable(),
                TextColumn::make('old_price')->prefix('Rs.')->sortable(),
                TextColumn::make('shipping_cost')->prefix('Rs.')->sortable(), // NEW COLUMN
                TextColumn::make('quantity')->sortable(),
                TextColumn::make('created_at')->sortable()->date('M d H:i'),
                TextColumn::make('updated_at')->sortable()->date('M d H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
                FilamentExportBulkAction::make('export'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

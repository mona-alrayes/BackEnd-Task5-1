<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;


class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       // Retrieve or create the Fiction category and its subcategories
       $fiction = Category::where('category', 'Fiction')->firstOrCreate(['category' => 'Fiction']);
       $classic = Subcategory::where('subcategory', 'Classic Literature')->firstOrCreate(['subcategory' => 'Classic Literature', 'category_id' => $fiction->id]);
       $fantasy = Subcategory::where('subcategory', 'Fantasy')->firstOrCreate(['subcategory' => 'Fantasy', 'category_id' => $fiction->id]);
       
       // Retrieve or create the Non-fiction category and its subcategories
       $nonFiction = Category::where('category', 'Non-fiction')->firstOrCreate(['category' => 'Non-fiction']);
       $historyNonFiction = Subcategory::where('subcategory', 'History')->firstOrCreate(['subcategory' => 'History', 'category_id' => $nonFiction->id]);
       $memoir = Subcategory::where('subcategory', 'Memoir')->firstOrCreate(['subcategory' => 'Memoir', 'category_id' => $nonFiction->id]);
       $selfHelp = Subcategory::where('subcategory', 'Self-help')->firstOrCreate(['subcategory' => 'Self-help', 'category_id' => $nonFiction->id]);

       // Science
       $science = Category::where('category', 'Science')->firstOrCreate(['category' => 'Science']);
       $physics = Subcategory::where('subcategory', 'Physics')->firstOrCreate(['subcategory' => 'Physics', 'category_id' => $science->id]);
       $biology = Subcategory::where('subcategory', 'Biology')->firstOrCreate(['subcategory' => 'Biology', 'category_id' => $science->id]);
       $genetics = Subcategory::where('subcategory', 'Genetics')->firstOrCreate(['subcategory' => 'Genetics', 'category_id' => $science->id]);

       // History
       $history = Category::where('category', 'History')->firstOrCreate(['category' => 'History']);
       $americanHistory = Subcategory::where('subcategory', 'American History')->firstOrCreate(['subcategory' => 'American History', 'category_id' => $history->id]);

       // Create books associated with the Fiction category and its subcategories
       Book::create([
           'title' => 'To Kill a Mockingbird',
           'author' => 'Harper Lee',
           'description' => '"To Kill a Mockingbird" is a classic American novel that addresses themes of racial injustice, moral growth, and compassion. Set in the 1930s in the fictional town of Maycomb, Alabama, it tells the story of young Scout Finch and her father, lawyer Atticus Finch, as he defends a black man falsely accused of raping a white woman.',
           'price' => '$12.99',
           'category_id' => $fiction->id,
           'subcategory_id' => $classic->id,
           'image' => '',
       ]);
        Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'description' => '"The Great Gatsby" is a novel set in the Roaring Twenties, a period of excess and decadence in America. It follows the enigmatic Jay Gatsby and his obsession with the beautiful Daisy Buchanan, exploring themes of love, wealth, and the American Dream.',
            'price' => '$9.99',
            'category_id' => $fiction->id,
            'subcategory_id' => $classic->id,
            'image' => '',
        ]);

        Book::create([
            'title' => 'The Hobbit',
            'author' => 'J.R.R. Tolkien',
            'description' => '"The Hobbit" is a fantasy novel that follows the journey of Bilbo Baggins, a hobbit who is swept into an epic quest to reclaim the lost kingdom of Erebor from the dragon Smaug. Along the way, Bilbo encounters trolls, elves, and Gollum, and discovers courage and adventure within himself.',
            'price' => '$8.99',
            'category_id' => $fiction->id,
            'subcategory_id' => $fantasy->id,
            'image' => '',
        ]);

        

        // Create books associated with the Non-fiction category and its subcategories
        Book::create([
            'title' => 'Sapiens: A Brief History of Humankind',
            'author' => 'Yuval Noah Harari',
            'description' => '"Sapiens" is a non-fiction book that offers a sweeping history of the human species, from the emergence of Homo sapiens in Africa to the present day. Drawing on insights from anthropology, biology, and history, Harari explores how Homo sapiens became the dominant species on Earth and the impact of human civilization on the planet.',
            'price' => '$15.99',
            'category_id' => $nonFiction->id,
            'subcategory_id' => $history->id,
            'image' => '',
        ]);

        Book::create([
            'title' => 'Becoming',
            'author' => 'Michelle Obama',
            'description' => '"Becoming" is a memoir by former First Lady Michelle Obama, in which she reflects on her life and experiences growing up on the South Side of Chicago, her career as a lawyer and public servant, and her time in the White House. With candor and grace, Obama shares personal anecdotes and insights into her journey of self-discovery and public service.',
            'price' => '$19.99',
            'category_id' => $nonFiction->id,
            'subcategory_id' => $memoir->id,
            'image' => '',
        ]);

        Book::create([
            'title' => 'The Subtle Art of Not Giving a F*ck',
            'author' => 'Mark Manson',
            'description' => '"The Subtle Art of Not Giving a F*ck" is a self-help book that offers unconventional advice on how to live a more meaningful and fulfilling life. Drawing on psychological research and personal anecdotes, Manson argues that happiness comes from embracing life\'s struggles and accepting one\'s limitations, rather than pursuing constant positivity and success.',
            'price' => '$13.99',
            'category_id' => $nonFiction->id,
            'subcategory_id' => $selfHelp->id,
            'image' => '',
        ]);
        
        Book::create([
            'title' => 'A Brief History of Time',
            'author' => 'Stephen Hawking',
            'description' => '"A Brief History of Time" is a popular science book that explores complex topics such as the Big Bang theory, black holes, and the nature of time. Written for a general audience, it provides insights into the mysteries of the universe and the quest for a unified theory of physics.',
            'price' => '$11.99',
            'category_id' => $science->id,
            'subcategory_id' => $physics->id,
            'image' => '',
        ]);

        Book::create([
            'title' => 'The Selfish Gene',
            'author' => 'Richard Dawkins',
            'description' => '"The Selfish Gene" is a groundbreaking work of evolutionary biology that explores the role of genes in driving natural selection and shaping behavior. Dawkins introduces the concept of the "selfish gene," arguing that organisms are vehicles for genes to propagate themselves, leading to insights into altruism, cooperation, and the origins of life.',
            'price' => '$14.50',
            'category_id' => $science->id,
            'subcategory_id' => $biology->id,
            'image' => '',
        ]);

        Book::create([
            'title' => 'The Gene: An Intimate History',
            'author' => 'Siddhartha Mukherjee',
            'description' => '"The Gene: An Intimate History" is a comprehensive exploration of the history, science, and ethics of genetics. Mukherjee traces the discovery of the gene from ancient times to the present day, weaving together personal stories, scientific breakthroughs, and ethical dilemmas to illuminate the profound impact of genetics on our lives.',
            'price' => '$16.99',
            'category_id' => $science->id,
            'subcategory_id' => $genetics->id,
            'image' => '',
        ]);

        
        Book::create([
            'title' => 'A People\'s History of the United States',
            'author' => 'Howard Zinn',
            'description' => '"A People\'s History of the United States" offers a revisionist perspective on American history, focusing on the experiences of marginalized groups such as Native Americans, African Americans, and women. Zinn challenges traditional narratives of U.S. history, highlighting the struggles for justice, equality, and democracy throughout the nation\'s past.',
            'price' => '$17.99',
            'category_id' => $history->id,
            'subcategory_id' => $americanHistory->id,
            'image' => '',
        ]);

    
    }
}

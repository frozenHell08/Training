<x-layout>
    <div id="contentbg" class="entryform">
        <div id="content">
            <h1 class="mine">Title</h1>
            <form method="POST" action="/">
                @csrf
                <div id="credentials" class="form-group">
                    <label for="title">Book Title</label>
                    <input id="title" name="title" placeholder="Book Title" type="text" class="input" required />

                    <label for="series">Series</label>
                    <input id="series" name="series" placeholder="Series" type="text" class="input" />

                    <label for="author">Author</label>
                    <input id="author" name="author" placeholder="Author" type="text" class="input" required />
                    
                    <label for="pubmonth">Publication</label>
                    <input id="pubmonth" name="pubmonth" placeholder="Publication Month" type="month" class="input" required />
                </div>

                <hr>
                <input id="btnSubmit" type="submit" value="Add Book"/>
                <input id="btnReset" type="reset" value="Reset Fields"/> 
            </form>
        </div>
    </div>
</x-layout>
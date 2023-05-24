<script>
    document.addEventListener('alpine:init', () => {

        Alpine.store('messages', {
            errors: [],
            success: [],
            // Handling errors from response
            handleErrors(res) {
                let data = res ? res.data : {};
                if (data.message) this.errors.push(data.message);

                if (data.errors) {
                    for (const [key, msgs] of Object.entries(data.errors)) {
                        if (msgs && msgs.length) msgs.forEach(m => { this.errors.push(m); console.log(m); })
                    }
                }
            }
        });

        Alpine.data('alpineApp', () => ({
            async deleteFile(id) {
                if (!confirm("Faylni o'chirishni xoxlaysizmi?")) return false;

                try {
                    const res = await axios.delete(`{{route('file.delete')}}/${id}`, {headers: defaultHeaders});
                    this.$store.messages.success.push('Fayl muvaffaqiyatli o\'chirildi');
                } catch (error) {
                    this.$store.messages.handleErrors(error.response);
                }
            }
        }));
    })
</script>

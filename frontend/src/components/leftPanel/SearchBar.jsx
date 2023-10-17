const SearchBar = ({ setSearchFields }) => {
  const handleChange = (e) => {
    setSearchFields(e.target.value);
  };
  return (
    <div>
      <input
        type="text"
        placeholder="Cherchez une discussion"
        className="input rounded-none w-full"
        onChange={(e) => handleChange(e)}
      />
    </div>
  );
};
export default SearchBar;
